<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Transaction;

class TransaksiController extends Controller
{
    public function index()
    {
        if ($this->authorize('MOD1008-read') || $this->authorize('spesial')) {
            $transactions = Transaction::where('status', '!=', 9)
                            ->orderBy('id', 'DESC')
                            ->paginate(10);

            return view('admin.transaksi.index', compact('transactions'));
        }
    }

    public function getData(Request $request)
    {
        if ($this->authorize('MOD1008-read') || $this->authorize('spesial')) {
            $search  = $request->get('search');
            $perpage = $request->get('list_perpage');

            if (!empty($search)) {
                $transactions = Transaction::where('status', '!=', 9)
                                ->where('transaction_code', 'LIKE', '%'.$search.'%')
                                ->paginate(10);
            } else {
                $transactions = Transaction::where('status', '!=', 9)
                                ->paginate(10);
            }

            return view('admin.transaksi.table-data', compact('transactions'));
        }
    }

    public function show($id)
    {
        if ($this->authorize('MOD1008-read') || $this->authorize('spesial')) {
            $transaction = Transaction::where('id', $id)
                        ->with('transactionDetail')
                        ->first();

            return response()->json([
                'success' => true,
                'message' => 'Berhasil mengambil data: '.$transaction->transaction_code.' dari database.',
                'data'    => $transaction
            ]);
        }
    }

    public function edit($id)
    {
        if ($this->authorize('MOD1008-read') || $this->authorize('spesial')) {
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
        if ($this->authorize('MOD1008-read') || $this->authorize('spesial')) {
            // code...
        }
    }

    public function destroy($id)
    {
        //
    }
}
