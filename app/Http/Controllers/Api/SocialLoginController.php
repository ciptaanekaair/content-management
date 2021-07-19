<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Http\Request;

class SocialLoginController extends Controller
{
    public function redirect($service)
    {
        service Socialite::driver($service)->stateless()->redirect();
    }

    public function callback($service)
    {
        $serviceUser = Socialite::driver($service)->stateless()->user();

        dd($serviceUser);
    }
}
