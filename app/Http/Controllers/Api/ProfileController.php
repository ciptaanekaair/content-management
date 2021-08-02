<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Image;
use Validator;
use App\Models\User;
use App\Models\UserDetail;
use App\Models\Provinsi;
use App\Models\Kota;
use App\Models\TransactionTemporary;

class ProfileController extends Controller
{
    // get user data.
    public function getProfile()
    {
        $profile  = User::with('userDetail')
                    ->where('id', auth()->user()->id)
                    ->first();

        $profile->cart_count = $profile->countQty();

        // $provinsis = Provinsi::orderBy('provinsi_name', 'ASC')->get();
        // $kotas     = Kota::orderBy('nama_kota', 'ASC')->get();

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
            'provinsi_id'   => 'numeric',
            'kota_id'       => 'numeric',
            'name'          => 'required|string',
            'profile_photo' => 'image|mimes:jpg,png,bmp,svg|max:3084'
        ];

        $validasi = Validator::make($request->all(), $rules);

        if ($validasi->fails()) {
            return response([
                'success' => false,
                'message' => $validasi->errors()
            ], 401);
        }

        $user = User::with('userDetail', 'carts')
                ->where('id', auth()->user()->id)
                ->first();
        $user->name = $request->name;

        if ($request->hasFile('profile_photo')) {
            if (Storage::exists('/public/'.$user->profile_photo_path)) {
                Storage::delete('/public/'.$user->profile_photo_path);
            }

            $simpan = $request->profile_photo->store('profile-photos', 'public');

            $user->profile_photo_path = $simpan;
        }

        if (!empty($request->password)) {
            $user->password = Hash::make($request->password);
        }

        $user->update();

        $cek_provinsi = Provinsi::find($request->provinsi_id);
        $cek_kota     = $this->checkKota($request->provinsi_id, $request->kota_id);

        if (!$cek_provinsi) {
            $provinsi = '';
        } else {
            $provinsi = $request->provinsi_id;
        }

        if ($cek_kota == false) {
            $kota = '';
        } else {
            $kota = $request->kota_id;
        }

        $user->userDetail->update([
            'alamat'      => $request->alamat,
            'provinsi_id' => $provinsi,
            'kota_id'     => $kota,
            'kode_pos'    => $request->kode_pos,
            'telepon'     => $request->telepon,
            'handphone'   => $request->handphone,
        ]);

        $response = [
            'success'     => true,
            'message'     => 'Anda berhasil update data profile.',
            'data'        => $user
        ];

        return response($response, 201);
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
        // $kota = Kecamatan::where($)
    }
}
