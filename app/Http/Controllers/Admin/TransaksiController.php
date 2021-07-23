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

        if (!epmty($search)) {
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

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
