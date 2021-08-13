<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\PasswordReset;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\ForgetPasswordMail;
use Validator;
use Session;
use Hash;

class ForgetPasswordController extends Controller
{
    public function index()
    {
        return view('auth.forgot-password');
    }

    public function indexResetPass()
    {
        return view('auth.password-reset2');
    }

    public function sendToken(Request $request)
    {
        $rules = [
            'email' => 'required|email'
        ];

        $pesan = [
            'email.required' => 'Form email harus diisi.',
            'email.email'    => 'Form email harus diisi dengan email Anda.'
        ];

        $validasi = Validator::make($request->all(), $rules, $pesan);

        if ($validasi->fails()) {
            return redirect()->route('forgetpassword.index')->withErrors($validasi)->withInput();
        }

        $p_reset = PasswordReset::where('email', $request->email)->delete();

        if ($this->checkEmailUser($request->email) == true) {
            $generate_token     = rand(111111, 999999);

            $data = User::where('email', $request->email)
                    ->first();
            $data->kode_rahasia = $generate_token;

            $reset = new PasswordReset;
            $reset->email      = $request->email;
            $reset->token      = md5($generate_token);
            $reset->created_at = date('Y-m-d H:i:s');
            $reset->save();

            Mail::to($request->email)->send(new ForgetPasswordMail($data));

            return view('auth.password-reset', compact('reset'));
        }

        Session::flash('alert', 'Maaf, sepertinya Anda belum pernah mendaftar sebelumnya dengan email tersebut');

        return redirect()->route('forgetpassword.index')->withInput();
    }

    public function resetPassword(Request $request)
    {
        $rules = [
            'email'                 => 'required|email',
            'token'                 => 'required|numeric|min:6',
            'password'              => 'required|string|min:6|confirmed',
            'password_confirmation' => 'required'
        ];

        $pesan = [
            'email.require'                  => 'Email wajib di isi.',
            'email.email'                    => 'Email tidak valid.',
            'token.required'                 => 'Kode rahasia wajib di isi.',
            'token.numeric'                  => 'Kode rahasia yang anda masukan salah!',
            'token.min'                      => 'Kode rahasia yang anda masukan salah!',
            'password.required'              => 'Password wajib di isi.',
            'password.string'                => 'Password berupa kombinasi huruf dan angka.',
            'password.min'                   => 'Password minimal 6 karakter.',
            'password.confirmed'             => 'Password yang Anda masukan tidak sama.',
            'password_confirmation.required' => 'Field Konfirmasi Password wajib di isi.'
        ];

        $validasi = Validator::make($request->all(), $rules, $pesan);

        if ($validasi->fails()) {
            // return redirect()->route('forgetpassword.indexResetPass')->withErrors($validasi)->withInput();
            return response()->json([
                'error'   => true,
                'message' => $validasi->errors()
            ], 422);
        }

        $check = PasswordReset::where('token', md5($request->token))
                ->first();

        if (!$check) {
            return response()->json([
                'error'   => true,
                'message' => ['token' => 'Token yang anda masukan salah.']
            ], 422);
        }

        $user = User::where('email', $check->email)->first();
        $user->password = Hash::make($request->password);
        $user->update();

        $check->delete();

        return response()->json([
            'success' => true,
            'message' => 'Berhasil merubah Password.',
            'data'    => $user
        ], 200);
    }

    protected function checkEmailUser($email)
    {
        $check = User::where('email', $email)->first();

        if (!empty($check)) {
            return true;
        }

        return false;
    }
}