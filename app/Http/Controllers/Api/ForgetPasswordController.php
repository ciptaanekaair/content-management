<?php

namespace App\Http\Controllers\Api;

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
    public function forgetPassword(Request $request)
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
            return response([
                'error'   => true,
                'message' => $validasi->errors()
            ], 422);
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

            return response([
                'success' => true,
                'message' => 'Berhasil melakukan permintaan perubahan password. Silahkan check email anda, untuk memasukan kode rahasia.'
            ], 200);
        }

        return response([
            'error'   => true,
            'message' => 'Gagal, email Anda tidak terdaftar pada sistem kami. Silahkan lakukan pendaftaran akun baru.'
        ], 401);
    }

    public function resetPassword(Request $request)
    {
        $rules = [
            'token'                 => 'required|numeric',
            'password'              => 'required|string|min:6|confirmed',
            'password_confirmation' => 'required'
        ];

        $pesan = [
            'token.required'                      => 'Kode rahasia wajib di isi.',
            'token.numeric'                       => 'Kode rahasia yang anda masukan salah!',
            'password.required'                   => 'Password wajib di isi.',
            'password.string'                     => 'Password berupa kombinasi huruf dan angka.',
            'password.min'                        => 'Password minimal 6 karakter.',
            'password.confirmed'                  => 'Password tidak sama. Pastikan password yang Anda masukan sama.',
            'password_confirmation.required'      => 'Field Konfirmasi Password wajib di isi.'
        ];

        $validasi = Validator::make($request->all(), $rules, $pesan);

        if ($validasi->fails()) {
            return response([
                'error'   => true,
                'message' => $validasi->errors()
            ]);
        }

        $check = PasswordReset::where('token', md5($request->token))
                ->first();

        if (!$check) {
            return response([
                'error'   => true,
                'message' => 'Kode rahasia yang anda masukan salah. Mohon perika kembali di email yang terdaftar.'
            ], 401);
        }

        $user = User::where('email', $check->email)->first();
        $user->password = Hash::make($request->password);
        $user->update();

        $check->delete();

        return response([
            'success' => true,
            'message' => 'Berhasil melakukan verifikasi token dan memperbarui password.',
            'data'    => $user,
        ]);
    }

    // public function verifyForgetPassword(Request $request)
    // {
    //     $rules = [
    //         'token' => 'required|numeric'
    //     ];

    //     $pesan = [
    //         'token.required' => 'Kode rahasia wajib di isi.',
    //         'token.numeric'  => 'Kode rahasia yang anda masukan salah!'
    //     ];

    //     $validasi = Validator::make($request->all(), $rules, $pesan);

    //     $check = PasswordReset::where('token', md5($request->token))
    //             ->first();

    //     if (!$check) {
    //         return response([
    //             'error'   => true,
    //             'message' => 'Gagal melakukan verifikasi. Silahkan melakukan verifikasi ulang.',
    //             'data'    => $check,
    //         ]);
    //     }

    //     return response([
    //         'success' => true,
    //         'message' => 'Berhasil melakukan verifikasi token. Silahkan masukan password baru yang ingin Anda gunakan.'
    //     ]);
    // }

    protected function checkEmailUser($email)
    {
        $check = User::where('email', $email)->first();

        if (!empty($check)) {
            return true;
        }

        return false;
    }
}
