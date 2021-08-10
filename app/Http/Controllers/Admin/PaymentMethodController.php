<?php

namespace App\Http\Controllers\Admin;

use App\Models\PaymentConfirmation;
use App\Models\Transaction;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Storage;

class PaymentMethodController extends Controller
{
    public function getDetail($id)
    {
        $pConfirmation = PaymentConfirmation::select('id', 'user_id', 'deskripsi', 'images', 'status', 'created_at')
                        ->where('transactions_id', $id)
                        ->get();

        if (!empty($pConfirmation)) {
            return view('admin.transaksi.table-payment', compact('pConfirmation'));
        }

        return view('admin.transaksi.table-payment', compact(['pConfirmation' => new PaymentConfirmation]));
    }

    public function verify($id)
    {
        $pConfirmation = PaymentConfirmation::find($id);

        if (!empty($pConfirmation)) {
            $pConfirmation->status = 1;
            $pConfirmation->update();

            $transaction = Transaction::find($id);
            $transaction->status = 7;
            $transaction->update();

            return response()->json([
                'success' => true,
                'message' => 'Berhasil verifikasi data pembayaran.'
            ], 200);
        }

        return response()->json([
            'error'   => true,
            'message' => 'Gagal mengambil data dari database.'
        ], 401);
    }

    public function unverify($id)
    {
        $pConfirmation = PaymentConfirmation::find($id);

        if (!empty($pConfirmation)) {
            $pConfirmation->status = 0;
            $pConfirmation->update();

            $transaction = Transaction::find($id);
            $transaction->status = 2;
            $transaction->update();

            return response()->json([
                'success' => true,
                'message' => 'Berhasil non-verifikasi data pembayaran.'
            ],200);
        }

        return response()->json([
            'error'   => true,
            'message' => 'Gagal mengambil data dari database.'
        ], 401);
    }

    public function terminated($id)
    {
        $pConfirmation = PaymentConfirmation::find($id);

        if (!empty($pConfirmation)) {
            $pConfirmation->status = 9;
            $pConfirmation->update();

            $transaction = Transaction::find($id);
            $transaction->status = 0;
            $transaction->update();

            return response()->json([
                'success' => true,
                'message' => 'Berhasil membatalkan pembayaran.'
            ],200);
        }

        return response()->json([
            'error'   => true,
            'message' => 'Gagal mengambil data dari database.'
        ], 401);
    }
}
