<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Auth;
use App\Models\User;

class AutentikasiController extends Controller
{
    // registrasi user melalui form register
    public function registrasi(Request $request)
    {
        $validasi = $request->validate([
            'name' => 'required|string',
            'email' => 'required|unique:users,email',
            'password' => 'required|confirmed',
        ]);

        $username = md5($validasi['email']);

        $user = User::create([
            'name'     => $validasi['name'],
            'email'    => $validasi['email'],
            'username' => $username,
            'password' => $validasi['password'],
            'level_id' => 1
        ]);

        // Generate token untuk API (sanctum)
        $token = $user->createToken('usertoken')->plainTextToken;

        // Give response dalam bentuk array
        $response = ['message' => 'Berhasil register data.', 'data' => $user, 'token' => $token];

        return response($response, 201);
    }

    public function login(Request $request)
    {
        $validasi = $request->validate([
            'email'    => 'required|email',
            'password' => 'required'
        ]);

        $user = User::where('email', $validasi['email'])->first();

        if (!$user || !Hash::check($validasi['password'], $user->password)) {

            $response = ['message' => 'Autentikasi gagal, pastikan data yang dimasukan benar!'];
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
