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
        try {
            $serviceUser = Socialite::driver($service)->stateless()->user();        
        } catch (InvalidStateException $e) {
            return response(['error' => true, 'message' => 'Gagal']);
        }

        $user = User::firstOrNew(['email' => $serviceUser->email]);
        $user->name              = $serviceUser->name;
        $user->username          = md5($serviceUser->email);
        $user->email_verified_at = date('Y-m-d H:i:s');
        $user->password          = Hash::make(rand(111111, 999999));
        $user->save();

        $token = $user->createToken('usertoken')->plainTextToken;

        return response([
            'success' => true,
            'message' => 'Berhasil melakukan autentikasi.',
            'data'    => $user,
            'token'   => $token
        ], 200);
    }
}
