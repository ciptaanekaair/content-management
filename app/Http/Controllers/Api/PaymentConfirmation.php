<?php

namespace App\Http\Controllers\Api;

use App\Models\PaymentConfirmation;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PaymentConfirmation extends Controller
{
    public function store(Request $request)
    {
        $rules = [
            'transactions_id' => 'required',
            'images'          => 'required|image|mimes:jpg,jpeg,png|max:3048',
        ];

        $pesan = [
            'transactions_id.required' => 'Transaksi tidak di temukan.',
            'images.required'          => 'Anda harus memasukan gambar/photo bukti pembayaran.',
            'images.image'             => 'Anda harus memasukan gambar/photo bukti pembayaran.',
            'images.mimes'             => 'File harus berekstensi: JPG/JPEG/PNG.',
            'images.max'               => 'File tidak boleh melebihi 3MB.'
        ];

        $validasi = Validator::make($request->all(), $rules, $pesan);

        if ($validasi->fails()) {
            return response([
                'error' => true,
                'message' => $validasi->errors()
            ], 401);
        }
    }
}
