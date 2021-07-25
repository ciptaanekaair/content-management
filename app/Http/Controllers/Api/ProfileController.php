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
        $profile  = User::with('userDetail', 'carts')
                    ->where('id', auth()->user()->id)
                    ->first();

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

        $user->userDetail->update([
            'alamat'      => $request->alamat,
            'kota_id'     => $request->kota_id,
            'provinsi_id' => $request->provinsi_id,
            'kode_pos'    => $request->kode_pos,
            'telepon'     => $request->telepon,
            'handphone'   => $request->handphone,
        ]);

        // // $detail = UserDetail::where('user_id', auth()->user()->id)->first();
        // $detail->alamat      = $request->alamat;
        // $detail->kota_id     = $request->kota_id;
        // $detail->provinsi_id = $request->provinsi_id;
        // $detail->kode_pos    = $request->kode_pos;
        // $detail->telepon     = $request->telepon;
        // $detail->handphone   = $request->handphone;
        // $detail->update();

        $response = [
            'success'     => true,
            'message'     => 'Anda berhasil update data profile.',
            'data'        => $user
        ];

        return response($response, 201);
    }
}
