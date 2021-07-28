<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use Auth;

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
        $transaction = Transaction::where('id', $id)
                        ->with('transactionDetail')
                        ->with('product')
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
        $transaction = Transaction::where('id', $id)
                        ->with('transactionDetail')
                        ->with('product')
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
            'payment_code_id' => 'requirement',
        ];
        $transaction = Transaction::where('id', $id)
                        ->with('transactionDetail')
                        ->with('product')
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
}
