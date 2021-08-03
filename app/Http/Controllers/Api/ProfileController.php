<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Image;
use Validator;
use App\Models\User;
use App\Models\UserDetail;
use App\Models\DetailPerusahaan;
use App\Models\Provinsi;
use App\Models\Kota;

class ProfileController extends Controller
{
    // get user data.
    public function getProfile()
    {
        $profile  = User::with('userDetail', 'detailPerusahaan')
                    ->where('id', auth()->user()->id)
                    ->first();

        $profile->cart_count = $profile->countQty();

        $response = [
            'success'     => true,
            'message'     => 'Berhasil load data.', 
            'data'        => $profile
        ];

        return response($response, 200);
    }

    public function updateProfile(Request $request)
    {
        $rules = [
            'profile_photo' => 'image|mimes:jpg,png,bmp,svg|max:3084'
        ];

        $pesan = [
            'name.string'         => 'field nama harus di isi',
            'profile_photo.image' => 'extensi hanya boleh: jpg/jpeg/png',
            'profile_photo.mimes' => 'extensi hanya boleh: jpg/jpeg/png',
            'profile_photo.max'   => 'maximal file berukuran 3MB'
        ];

        $validasi = Validator::make($request->all(), $rules, $pesan);

        if ($validasi->fails()) {
            return response([
                'error' => true,
                'message' => $validasi->errors()
            ], 401);
        }

        $user = User::where('id', auth()->user()->id)
                ->first();

        if ($request->filled('name')) {
            $user->name = $request->name;
        }

        if ($request->hasFile('profile_photo')) {
            if (Storage::exists('/public/'.$user->profile_photo_path)) {
                Storage::delete('/public/'.$user->profile_photo_path);
            }

            $simpan                   = $request->profile_photo->store('profile-photos', 'public');
            $user->profile_photo_path = $simpan;
        }

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->update();

        $detail = UserDetail::where('user_id', $user->id)->first();

        if ($request->filled('provinsi_id')) {
            $cek_provinsi = Provinsi::find($request->provinsi_id);
            if ($cek_provinsi) {
                $detail->provinsi_id = $request->provinsi_id;
            }
        }

        if ($request->filled('kota_id')) {
            $cek_kota     = $this->checkKota($request->provinsi_id, $request->kota_id);
            if ($cek_kota == true) {
                $detail->kota_id = $request->kota_id;
            } else {
                return response([
                    'error'   => true,
                    'message' => 'Kota tidak terdapat di dalam provinsi yang anda pilih.'
                ], 401);
            }
        }

        if ($request->filled('alamat')) {
            $detail->alamat = $request->alamat;
        }

        if ($request->filled('telepon')) {
            $detail->telepon   = $request->telepon;
        }

        if ($request->filled('handphone')) {
            $detail->handphone = $request->handphone;
        }

        if ($request->filled('kode_pos')) {
            $detail->kode_pos  = $request->kode_pos;
        }

        $detail->save();

        $response = [
            'success'     => true,
            'message'     => 'Anda berhasil update data profile.',
            'data'        => [$user, $detail]
        ];

        return response($response, 201);
    }

    public function updateProfilePerusahaan(Request $request)
    {
        $rule = [
            'provinsi_id'  => 'numeric',
            'kota_id'      => 'numeric',
            'kecamatan_id' => 'numeric',
            'kode_pos'     => 'numeric',
            'telepon'      => 'numeric',
            'fax'          => 'numeric',
            'handphone'    => 'numeric'
        ];

        $pesan = [
            'provinsi_id.numeric'  => 'Anda harus mengisi menggunakan form yang di sediakan.',
            'kota_id.numeric'      => 'Anda harus mengisi menggunakan form yang di sediakan.',
            'kecamatan_id.numeric' => 'Anda harus mengisi menggunakan form yang di sediakan.',
            'kode_pos.numeric'     => 'Kode Pos haruslah di isi menggunakan angka.',
            'telepon.numeric'      => 'Telepon harus di isi dengan menggunakan angka.',
            'fax.numeric'          => 'Fax harus di isi menggunakan angka',
            'handphone.numeric'    => 'Nomor Handphone harus di isi menggunakan angka.'
        ];

        $validasi = Validator::make($request->all(), $rules, $pesan);

        if ($validasi->fails()) {
            return response([
                'error'   => true,
                'message' => $validasi->errors()
            ]);
        }

        $perusahaan = DetailPerusahaan::where('user_id', auth()->user()->id)->first();

        if (!empty($perusahaan)) {

            $perusahaan->nama_pt = $request->nama_pt;

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
                if (Storage::exists('/public/'.$request->npwp_image)) {
                    Storage::delete('/public/'.$request->npwp_image);
                }
                $simpan                 = $request->npwp_image->store('perusahaan_images', 'public');
                $perusahaan->npwp_image = $simpan;
            }

            $perusahaan->update();

            return response([
                'success'     => true,
                'message'     => 'Anda berhasil update data profile perusahaan.',
                'data'        => $perusahaan
            ]);
        }

        return response([
            'error'   => true,
            'message' => 'Data tidak ditemukan. Sepertinya anda terdatar sebagai perorangan.'
        ]);
    }

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

    public function checkKecamatan($kota_id, $kecamatan_id)
    {
        $kecamatan = Kecamatan::find($kecamatan_id);

        if(!empty($kecamatan)) {
            if ($kecamatan->kota_id != $kota_id) {
                return false;
            }

            return true;
        }

        return false;
    }
}
