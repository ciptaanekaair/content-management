<?php

namespace App\Http\Controllers\Api;

use App\Models\PaymentConfirmation;
use App\Models\Transaction;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Storage;
use Validator;

class PaymentConfirmationController extends Controller
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

        if ($this->checkTransaction(auth()->user()->id, $request->transactions_id) == true) {
            $transaction = Transaction::find($request->transactions_id);
            $transaction->status = 2;
            $transaction->update();

            $confirm = new PaymentConfirmation;
            $confirm->transactions_id = $request->transactions_id;
            $confirm->user_id         = auth()->user()->id;

            if ($request->hasFile('images')) {
                $simpan          = $request->images->store('bukti_pembayaran', 'public');
                $confirm->images = $simpan;
            }

            if ($request->filled('deskripsi')) {
                $confirm->deskripsi = $request->deskripsi;
            }

            $confirm->status = 0;
            $confirm->save();

            return response([
                'success' => true,
                'message' => 'Berhasil upload bukti bayar.',
                'data'    => $confirm
            ]);
        }

        return response([
            'error'   => true,
            'message' => 'Transaksi tidak ditemukan, silahkan refresh browser anda.'
        ]);

    }

    public function checkTransaction($user_id, $id)
    {
        $check = Transaction::where('id', $id)->first();

        if (!empty($check)) {
            if ($check->user_id == $user_id) {
                return true;
            }

            return false;
        }

        return false;
    }
}
