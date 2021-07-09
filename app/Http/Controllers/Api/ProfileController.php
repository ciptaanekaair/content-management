<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Image;
use App\Models\User;

class ProfileController extends Controller
{
    // get user data.
    public function getProfile($username)
    {
        $profile  = User::select('users.name', 'users.email', 'users.username', 'users.level_id')->where('username', $username)->first();

        $response = ['message' => 'Berhasil load data.', 'data' => $profile];

        return response($response, 200);
    }

    public function updateProfile(Request $request, $username)
    {
        $rules = [
            'name' => 'string',
            'profile_photo' => 'image|mimes:jpg,png,bmp,svg|max:3084'
        ];

        $validasi = Validator::make($request->all(), $rules);

        $user = User::where('username', $username)->first();
        $user->name = $request['name'];

        if ($request->hasFile('profile_photo')) {
            if (Storage::exists('storage/'.$user->profile_photo_path)) {
                Storage::delete('storage/'.$user->profile_photo_path);
            }

            // $photo  = $request->file('profile_photo');
            $simpan = $request->profile_photo->storeAs('profile-photos', 'public');

            $user->profile_photo_path = $simpan;
        }

        if (!empty($request->password)) {
            $user->password = Hash::make($request['password']);
        }

        $user->update();

        $response = [
            'success' => true,
            'message' => 'Anda berhasil update data profile.',
            'data' => $user
        ];

        return response($response, 200);
    }
}
