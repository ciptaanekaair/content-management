<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Auth;
use Validator;
use App\Models\User;
use App\Models\UserDetail;
use App\Models\DetailPerusahaan;

class AutentikasiController extends Controller
{
    // registrasi user melalui form register
    public function registrasi(Request $request)
    {
        $rules = [
            'name' => 'required|string',
            'email' => 'required|unique:users,email',
            'password' => 'required|confirmed',
        ];

        $pesan = [
            'name.required' => 'Field Nama wajib di isi.',
            'name.required' => 'Field Nama harus berupa huruf, tak boleh memasukan simbol ataupun angka.',
            'email.required' => 'Silahkan masukan email yang benar.',
            'email.required' => 'Email telah digunakan. Siahkan menggunakan email baru',
        ];

        $validasi = Validator::make($request->all(), $rules);

        if ($validasi->fails()) {
            return response([
                'success' => false,
                'message' => $validasi->errors(),
            ], 400);
        }

        $username = md5($request['email']);

        $user = User::create([
            'name'     => $request['name'],
            'email'    => $request['email'],
            'username' => $username,
            'password' => Hash::make($request['password']),
            'level_id' => 1
        ]);

        if ($request->filled('nama_pt')) {
            $perusahaan = new DetailPerusahaan;
            $perusahaan->user_id      = $user->id;
            $perusahaan->nama_pt      = $request->nama_pt;

            if ($request->filled('alamat_pt')) {
                $perusahaan->alamat_pt = $request->alamat_pt;
            }
            if ($request->filled('provinsi_id')) {
                $perusahaan->provinsi_id = $request->provinsi_id;
            }
            if ($request->filled('kota_id')) {
                $perusahaan->kota_id = $request->kota_id;
            }
            if ($request->filled('kecamatan_id')) {
                $perusahaan->kecamatan_id = $request->kecamatan_id;
            }
            if ($request->filled('kode_pos')) {
                $perusahaan->kode_pos = $request->kode_pos;
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
        }

        UserDetail::create(['user_id' => $user->id]);

        // Generate token untuk API (sanctum)
        $token = $user->createToken('usertoken')->plainTextToken;

        // Give response dalam bentuk array
        $response = ['message' => 'Berhasil register data.', 'data' => $user, 'token' => $token];

        return response($response, 201);
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

    public function logout(Request $request)
    {
        // delete API token.
        Auth::user()->tokens()->delete();

        return response(['message' => 'Anda berhasil keluar.'], 200);
    }
}
