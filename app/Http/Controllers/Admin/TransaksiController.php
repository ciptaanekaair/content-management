<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Transaction;

class TransaksiController extends Controller
{
    public function index()
    {
        $transactions = Transaction::where('status', '!=', 9)
                        ->orderBy('id', 'DESC')
                        ->paginate(10);

        return view('admin.transaksi.index', compact('transactions'));
    }

    public function getData(Request $request)
    {
        $search  = $request->get('search');
        $perpage = $request->get('list_perpage');

        if (!empty($search)) {
            $transactions = Transaction::where([
                            ['status', '!=', 9],
                            ['transaction_code', 'LIKE', '%'.$search.'%']
                        ])->paginate(10);
        } else {
            $transactions = Transaction::where('status', '!=', 9)
                            ->paginate(10);
        }

        return response()->json([
            'success' => true,
            'message' => 'Berhasil mengambil data dari database.',
            'data'    => $transactions
        ]);
    }

    public function show($id)
    {
        $transaction = Transaction::with('transactionDetail')
                    ->where('id', $id)
                    ->first();

        return response()->json([
            'success' => true,
            'message' => 'Berhasil mengambil data: '.$transaction->transaction_code' dari database.',
            'data'    => $transaction
        ]);
    }

    public function edit($id)
    {
        $transaction = Transaction::with('transactionDetail')
                    ->where('id', $id)
                    ->first();

        return response()->json([
            'success' => true,
            'message' => 'Berhasil mengambil data: '.$transaction->transaction_code' dari database.',
            'data'    => $transaction
        ]);
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
}
