<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\ConfirmRegistrationMail;
use Auth;
use Validator;
use App\Models\User;
use App\Models\UserDetail;
use App\Models\DetailPerusahaan;
use App\Models\Provinsi;
use App\Models\Kota;
use App\Models\UserConfirmation;

class AutentikasiController extends Controller
{
    // registrasi user melalui form register
    public function registrasi(Request $request)
    {
        $rules = [
            'name'       => 'required|string',
            'email'      => 'required|unique:users,email',
            'password'   => 'required|confirmed',
            'npwp_image' => 'image|mimes:jpg,jpeg,png|max:4112'
        ];

        $pesan = [
            'name.required'    => 'Field Nama wajib di isi.',
            'name.required'    => 'Field Nama harus berupa huruf, tak boleh memasukan simbol ataupun angka.',
            'email.required'   => 'Silahkan masukan email yang benar.',
            'email.required'   => 'Email telah digunakan. Siahkan menggunakan email baru',
            'npwp_image.image' => 'File npwp harus berupa photo/image.',
            'npwp_image.mimes' => 'File harus berekstensi: JPG/JPEG/PNG',
            'npwp_image.max'   => 'File terlalu bersar. Ukuran file tidak boleh lebih dari 4MB'
        ];

        $validasi = Validator::make($request->all(), $rules);

        if ($validasi->fails()) {
            return response([
                'success' => false,
                'message' => $validasi->errors(),
            ], 400);
        }

        $username = md5($request['email']);

        if ($request->nama_pt != '') {

            $user = User::create([
                'name'     => $request['name'],
                'email'    => $request['email'],
                'username' => $username,
                'password' => Hash::make($request['password']),
                'company'  => 1,
                'level_id' => 1,
                // 'status'   => 0
            ]);

            $perusahaan = new DetailPerusahaan;
            $perusahaan->user_id      = $user->id;
            $perusahaan->nama_pt      = $request->nama_pt;

            if ($request->filled('alamat_pt')) {
                $perusahaan->alamat_pt = $request->alamat_pt;
            }
            if ($request->filled('provinsi_id')) {
                // Check provinsi
                $cek_provinsi = Provinsi::find($request->provinsi_id);
                if ($cek_provinsi) {
                    $perusahaan->provinsi_id = $request->provinsi_id;
                }
            }
            if ($request->filled('kota_id')) {
                // Check Kota
                $cek_kota = $this->checkKota($request->provinsi_id, $request->kota_id);
                if ($cek_kota == true) {
                    $perusahaan->kota_id = $request->kota_id;
                } else {
                    return response([
                        'error'   => true,
                        'message' => 'Kota tidak terdapat di dalam provinsi yang anda pilih.'
                    ], 401);
                }
            }
            if ($request->filled('kecamatan_id')) {
                $perusahaan->kecamatan_id = $request->kecamatan_id;
            }
            if ($request->filled('kode_pos')) {
                if ($request->kode_pos != null) {
                    $perusahaan->kode_pos = $request->kode_pos;
                }
            }
            if ($request->filled('telepon')) {
                $perusahaan->telepon = $request->telepon;
            }
            if ($request->filled('fax')) {
                $perusahaan->fax = $request->fax;
            }
            if ($request->filled('handphone')) {
                $perusahaan->handphone = $request->handphone;
            }
            if ($request->filled('npwp')) {
                $perusahaan->npwp = $request->npwp;
            }
            if ($request->hasFile('npwp_image')) {
                $simpan                 = $request->npwp_image->store('perusahaan_images', 'public');
                $perusahaan->npwp_image = $simpan;
            }

            $perusahaan->status = 0;
            $perusahaan->save();
        } else {

            $user = User::create([
                'name'     => $request['name'],
                'email'    => $request['email'],
                'username' => $username,
                'password' => Hash::make($request['password']),
                'company'  => 0,
                'level_id' => 1,
                // 'status'   => 0
            ]);

        }

        UserDetail::create(['user_id' => $user->id]);

        $cekConfirm = UserConfirmation::where('email', $request['email'])->first();

        if (!empty($cekConfirm)) {

            $cekConfirm->code = base64_encode($request['email'].date('Y-m-d'));
            $cekConfirm->save();

            Mail::to($request['email'])->send(new ConfirmRegistrationMail($cekConfirm));

        } else {

            $confirm = UserConfirmation::create([
                'email' => $request['email'],
                'code'  => base64_encode($request['email'].date('Y-m-d'))
            ]);

            Mail::to($request['email'])->send(new ConfirmRegistrationMail($confirm));

        }

        // Generate token untuk API (sanctum)
        $token = $user->createToken('usertoken')->plainTextToken;

        // Give response dalam bentuk array
        $response = ['message' => 'Berhasil register data.', 'data' => $user, 'token' => $token];

        return response($response, 201);
    }

    public function registrationConfirmation(Request $request)
    {
        $rules = [
            'email' => 'required|email',
            'code'  => 'required'
        ];

        $pesan = [
            'email.required' => 'Link sudah kadaluarsa, silahkan lakukan confirmasi email ulang',
            'email.email'    => 'Link sudah kadaluarsa, silahkan lakukan confirmasi email ulang',
            'code.required'  => 'Link sudah kadaluarsa, silahkan lakukan confirmasi email ulang'
        ];

        $validasi = Validator::make($request->all(), $rules, $pesan);

        if ($validasi->fails()) {

            return response([
                'error'   => true,
                'message' => $validasi->errors()
            ], 403);

        }

        $cek = $this->checkRegistration($request->email, $request->code);

        if ($cek == false) {
            return response([
                'error'   => true,
                'message' => 'Link error. Silahkan lakukan konfimasi email kembali.'
            ], 403);
        }

        $confirm = UserConfirmation::where('email', $user->email)
                    ->where('code', $request->code)
                    ->first();
        $confirm->delete();

        $user = User::where('email', $request->email)->first();
        $user->email_verified_at = date('Y-m-d H:i:s');
        $user->status            = 1;
        $user->update();

        return response([
            'success' => true,
            'message' => 'Berhasil melakukan konfirmasi email. Selamat berbelanja.'
        ]);
    }

    public function login(Request $request)
    {
        $rules = [
            'email'    => 'required|email',
            'password' => 'required'
        ];

        $validasi = Validator::make($request->all(), $rules);

        if ($validasi->fails()) {
            return response([
                'success' => false,
                'message' => $validasi->errors()
            ], 401);
        }

        $user = User::where('email', $request['email'])->first();

        if (!$user || !Hash::check($request['password'], $user->password)) {

            $response = ['message' => 'Autentikasi gagal. pastikan data yang dimasukan benar!'];
            return response($response, 401);

        }

        // Generate token untuk API (sanctum)
        $token = $user->createToken('usertoken')->plainTextToken;

        // Give response dalam bentuk array
        $response = ['message' => 'Berhasil melakukan autentikasi.', 'data'=> $user, 'token' => $token];

        return response($response, 200);
    }

    // Check kota
    public function checkKota($provinsi_id, $kota_id)
    {
        $kota = Kota::find($kota_id);

        if (!empty($kota)) {
            if ($kota->provinsi_id != $provinsi_id) {
                return false;
            }

            return true;
        }

        return false;
    }

    public function checkRegistration($pengguna, $kode)
    {
        $check = UserConfirmation::where('email', $pengguna)
                ->where('code', $kode)
                ->first();

        if (!empty($check)) {
            return true;
        }

        return false;
    }

    public function logout(Request $request)
    {
        // delete API token.
        Auth::user()->tokens()->delete();

        return response(['message' => 'Anda berhasil keluar.'], 200);
    }
}
