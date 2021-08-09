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
            'images'          => 'required|image|mimes:jpg,jpeg,png|max:5140',
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

            if (auth()->user()->company == 1) {
                if (auth()->user()->detailPerusahaan->status == 0) {
                    return response([
                        'error'   => true,
                        'message' => 'Status Perusahaan belum terkonfirmasi oleh Admin. Silahkan chat admin.'
                    ], 422);
                }
            }

            if ($this->checkPaymentConfirmation($request->transactions_id) == true) {
                return response([
                    'error'   => true,
                    'message' => 'Anda telah melakukan konfirmasi pembayaran. Untuk kembali melakukan konfirmasi pembayaran yang baru, Anda harus menunggu hingga Admin merubah status payment confirmation menjadi ditolak.'
                ], 422);
            }

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

    public function checkPaymentConfirmation($transaction_id)
    {
        $check = PaymentConfirmation::where('transaction_id', $transaction_id)->first();

        if (!empty($check)) {
            if ($check->status == 0) {
                return true;
            }

            return false;
        }

        return false;
    }
}
