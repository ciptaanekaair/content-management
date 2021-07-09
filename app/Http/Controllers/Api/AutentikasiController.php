<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Auth;
use Validator;
use App\Models\User;

class AutentikasiController extends Controller
{
    // registrasi user melalui form register
    public function registrasi(Request $request)
    {
        $rules = [
            'name' => 'required|string',
            'email' => 'required|unique:users,email',
            'password' => 'required|confirmed',
        ];

        $validasi = Validator::make($request->all(), $rules);

        if ($validasi->fails()) {
            return response([
                'success' => false,
                'message' => $validasi->errors(),
            ], 400);
        }

        $username = md5($request['email']);

        $user = User::create([
            'name'     => $request['name'],
            'email'    => $request['email'],
            'username' => $username,
            'password' => $request['password'],
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
        $rules = [
            'email'    => 'required|email',
            'password' => 'required'
        ];

        $validasi = Validator::make($request->all(), $rules);

        if ($validasi->fails()) {
            return response([
                'success' => false,
                'message' => $validasi->errors()
            ], 401);
        }

        $user = User::where('email', $request['email'])->first();

        if (!$user || !Hash::check($request['password'], $user->password)) {

            $response = ['message' => 'Autentikasi gagal. pastikan data yang dimasukan benar!'];
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
