<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Storage;
use Validator;
use Rule;

class ProfileController extends Controller
{
    public function index()
    {
        $user = User::where('id', auth()->user()->id)
                ->with('userDetail')->first();

        return view('admin.profile.index', compact('user'));
    }

    public function updatePassword(Request $request)
    {
        $rules = [
            'password'              => 'required|string|min:6|confirmed',
            'password_confirmation' => 'required'
        ];

        // $this->validate($request, $rules);
        $validasi = Validator::make($request->all(), $rules);

        if ($validasi->fails()) {
            return response()->json([
                'error'   => true,
                'message' => $validasi->errors()
            ], 422);
        }

        return response()->json([
            'success' => true,
            'message' => 'Berhasil merubah password.',
            'data' => $request->all()
        ], 200);
    }

    public function updateProfile(Request $request)
    {
        $rules = [
            'name'               => 'required',
            'profile_photo_path' => 'image|mimes:jpg,jpeg,png|max:2048'
        ];

        $validasi = Validator::make($request->all(), $rules);

        if ($validasi->fails()) {
            return response()->json([
                'error'   => true,
                'message' => $validasi->errors()
            ], 422);
        }

        $profile = User::where('id', auth()->user()->id)->first();

        if (!empty($profile)) {
            if ($request->hasFile('profile_photo_path')) {
                if (Storage::exists('/public/'.$profile->profile_photo_path)) {
                    Storage::delete('/public/'.$profile->profile_photo_path);
                }

                $simpan = $request->profile_photo_path->store('profile-photos', 'public');
                $profile->profile_photo_path = $simpan;
            }

            $profile->name = $request->name;
            $profile->save();

            return response()->json([
                'success' => true,
                'message' => 'Berhasil update data profile.',
                'data'    => $profile
            ], 200);
        }

        return response()->json([
            'success' => true,
            'message' => 'Berhasil update data profile.',
            'data'    => $profile
        ], 200);
    }

    public function updateDetail(Request $request)
    {
        // code...
    }

    public function getProfile($username)
    {
        $user = User::with('userDetail')
                ->where('id', auth()->user()->id)
                ->frist();

        return view('admin.profile.index', compact('user'));
    }
}
