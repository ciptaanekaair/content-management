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

        $provinsis = Provinsi::orderBy('provinsi_name', 'ASC')->get();
        $kotas     = Kota::orderBy('nama_kota', 'ASC')->get();
        $carts     = TransactionTemporary::where('user_id', auth()->user()->id)->get();

        $harga_total = 0;

        if ($carts->count() > 0)
        {
            foreach ($carts as $item) {
                $harga_total += $item->total_price;
            }
        }

        $response = [
            'success'     => true,
            'message'     => 'Berhasil load data.', 
            'data'        => $profile,
            'provinsis'   => $provinsis,
            'kotas'       => $kotas,
            'carts'       => $carts,
            'harga_total' => $harga_total
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

        $user = User::find(auth()->user()->id);
        $user->name = $request->name;

        if ($request->hasFile('profile_photo')) {
            if (Storage::exists('/public/'.$user->profile_photo_path)) {
                Storage::delete('/public/'.$user->profile_photo_path);
            }

            // $photo  = $request->file('profile_photo');
            $simpan = $request->profile_photo->store('profile-photos', 'public');

            $user->profile_photo_path = $simpan;
        }

        if (!empty($request->password)) {
            $user->password = Hash::make($request->password);
        }

        $user->update();

        $detail = UserDetail::where('user_id', auth()->user()->id)->first();
        $detail->alamat      = $request->alamat;
        $detail->kota_id     = $request->kota_id;
        $detail->provinsi_id = $request->provinsi_id;
        $detail->kode_pos    = $request->kode_pos;
        $detail->telepon     = $request->telepon;
        $detail->handphone   = $request->handphone;
        $detail->update();

        $response = [
            'success'     => true,
            'message'     => 'Anda berhasil update data profile.',
            'data'        => $user,
            'user_detail' => $detail
        ];

        return response($response, 201);
    }
}
