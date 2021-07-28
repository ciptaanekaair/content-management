<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use Auth;
use Validator;

class TransactionController extends Controller
{
    public function index(Request $request)
    {
        $transactions = Transaction::where('user_id', auth()->user()->id)
                        ->where('status', '!=', 9)
                        ->orderBy('id', 'DESC')
                        ->get();

        if (!empty($transactions)) {
            return response([
                'success' => true,
                'message' => 'Berhasil mengambil data transaksi dari database.',
                'data'    => $transactions
            ], 200);
        }

        return response([
            'error'   => true,
            'message' => 'Belum ada data transaksi yang pernah Anda buat.'
        ], 401);
    }

    public function show(Request $request, $id)
    {
        $transaction = Transaction::where('user_id', auth()->user()->id)
                        ->where('id', $id)
                        ->with('transactionDetail.products')
                        ->first();

        if (!empty($transaction)) {
            return response([
                'success' => true,
                'message' => 'Berhasil mengambil detail transaksi yang di pilih.',
                'data'    => $transaction
            ]);
        }

        return response([
            'error'   => true,
            'message' => 'Data transaksi tidak ada, silahkan refresh browser Anda.'
        ], 401);
    }

    public function edit(Request $request, $id)
    {
        $transaction = Transaction::where('user_id', auth()->user()->id)
                        ->where('id', $id)
                        ->with('transactionDetail.products')
                        ->first();

        if (!empty($transaction)) {
            return response([
                'success' => true,
                'message' => 'Berhasil mengambil detail transaksi yang di pilih.',
                'data'    => $transaction
            ]);
        }

        return response([
            'error'   => true,
            'message' => 'Data transaksi tidak ada, silahkan refresh browser Anda.'
        ], 401);
    }

    public function update(Request $request, $id)
    {
        $rules = [
            'payment_code_id' => 'required',
        ];
        $transaction = Transaction::where('user_id', auth()->user()->id)
                        ->where('id', $id)
                        ->with('transactionDetail')
                        ->first();

        if (!empty($transaction)) {
            $transaction->payment_code_id = $request->payment_code_id;
            $transaction->update();

            return response([
                'success' => true,
                'message' => 'Berhasil mengambil detail transaksi yang di pilih.',
                'data'    => $transaction
            ]);
        }

        return response([
            'error'   => true,
            'message' => 'Data transaksi tidak ada, silahkan refresh browser Anda.'
        ], 401);
    }


    public function cancel(Request $request)
    {
        $rule = [
            'transaction_id' => 'required|numeric'
        ];

        $validasi = Validator::make($request->all(), $rule);

        if ($validasi->fails()) {
            return response([
                'error'   => true,
                'message' => 'Gagal! Data transaksi tidak di temukan. Silahkan refresh browser anda.'
            ], 401);
        }

        $transaction = Transaction::where('user_id', auth()->user()->id)
                    ->where('id', $request->transaction_id)
                    ->first();

        if (!empty($transaction)) {
            $transaction->status = 6;
            $transaction->update();

            return response([
                'success' => true,
                'message' => 'Berhasil membatalkan transaksi.'
            ], 200);
        }

        return response([
            'error'   => true,
            'message' => 'Gagal! Data transaksi tidak di temukan. Silahkan refresh browser anda.'
        ], 401);
    }
}
