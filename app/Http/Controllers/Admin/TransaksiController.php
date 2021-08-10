<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Transaction;
use Validator;
use Storage;

class TransaksiController extends Controller
{
    public function index()
    {
        if ($this->authorize('MOD1008-read')) {
            $transactions = Transaction::where('status', '!=', 9)
                            ->orderBy('id', 'DESC')
                            ->paginate(10);

            return view('admin.transaksi.index', compact('transactions'));
        }
    }

    public function getData(Request $request)
    {
        if ($this->authorize('MOD1008-read')) {
            $search  = $request->get('search');
            $perpage = $request->get('list_perpage');

            if (!empty($search)) {
                $transactions = Transaction::where('status', '!=', 9)
                                ->where('transaction_code', 'LIKE', '%'.$search.'%')
                                ->paginate($perpage);
            } else {
                $transactions = Transaction::where('status', '!=', 9)
                                ->paginate($perpage);
            }

            return view('admin.transaksi.table-data', compact('transactions'));
        }
    }

    public function showAjax($id)
    {
        if ($this->authorize('MOD1008-read')) {
            $transaction = Transaction::where('id', $id)
                        ->with('transactionDetail.products', 'paymentConfirmation', 'user')
                        ->first();

            return response()->json($transaction);
        }
    }

    public function show($id)
    {
        if ($this->authorize('MOD1008-read')) {
            $transaction = Transaction::where('id', $id)
                        ->with('transactionDetail.products', 'paymentConfirmation', 'user')
                        ->first();

            return view('admin.transaksi.detail', compact('transaction'));
        }
    }

    public function edit($id)
    {
        if ($this->authorize('MOD1008-read')) {
            $transaction = Transaction::join('transaction_details', 
                        'transactions.id', '=', 'transaction_details.transactions_id')
                        ->where('transactions.id', $id)
                        ->get();

            return response()->json([
                'success' => true,
                'message' => 'Berhasil mengambil data: '.$transaction->transaction_code.' dari database.',
                'data'    => $transaction
            ]);
        }
    }

    public function update(Request $request, $id)
    {
        if ($this->authorize('MOD1008-read')) {
            $rules = [
                'status' => 'required|numeric'
            ];

            $pesan = [
                'status.required' => 'Status transaksi harus di isi.',
                'status.numeric'  => 'Status transaksi harus di isi.',
            ];

            $this->validate($request, $rules, $pesan);

            $transaksi = Transaction::find($id);

            if (!empty($transaksi)) {
                $transaksi->status = $request->status;
                $transaksi->update();

                return response()->json([
                    'success' => true,
                    'message' => 'Berhasil mengubah status transaksi.',
                    'data'    => $transaksi
                ]);
            }

            return response()->json([
                'error'   => true,
                'message' => 'Gagal mengubah status transaksi. Silahkan refresh browser anda.'
            ]);
        }
    }

    public function destroy($id)
    {
        //
    }
}
