<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Laravel\Socialite\Facades\Socialite;
use Hash;
use App\Models\User;

class SocialLoginController extends Controller
{
    public function __construct()
    {
        return $this->middleware('social');
    }

    public function redirect($service)
    {
        return Socialite::driver($service)->stateless()->redirect();
    }

    public function callback($service)
    {
        $serviceUser = Socialite::driver($service)->stateless()->user();

        $cek_user = User::where('email', $serviceUser->email)->first();

        if (!empty($cek_user)) {
            $simpan = $serviceUser->getAvatar->storeAs('profile-photos', 'public');
            
            $token = $cek_user->createToken('usertoken')->plainTextToken;

            return response([
                'success' => true,
                'message' => 'Berhasil melakukan autentikasi.',
                'data'    => $cek_user
            ]);
        }

        $user = User::create([
                'name'               => $serviceUser->getName,
                'email'              => $serviceUser->getEmail,
                'email_verified_at'  => date('Y-m-d H:i:s'),
                'password'           => Hash::make(rand('111111', '999999')),
                'profile_photo_path' => $simpan
            ]);

        $token = $user->createToken('usertoken')->plainTextToken;

        return response([
            'success' => true,
            'message' => 'Berhasil melakukan autentikasi.',
            'data'    => $user
        ]);
    }
}
