<?php

namespace App\Http\Controllers\Admin;

use App\Models\Shipping;
use App\Models\Transaction;
use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;

class ShippingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if ($this->authorize('MOD1208-read')) {
            $kurirs = User::where('status', '!=', 9)
                    ->where('level_id', 6)
                    ->orderBy('name', 'ASC')
                    ->get();

            return view('admin.shipping.index', compact('kurirs'));
        }
    }

    public function getData(Request $request)
    {
        if ($this->authorize('MOD1208-read')) {
            $search          = $request->get('search');
            $list_perpage    = $request->get('list_perpage');
            $jenis_transaksi = $request->get('jenis_transaksi');

            if (!empty($search)) {
                $transactions = Transaction::where('status', $jenis_transaksi)
                            ->where('transaction_code', 'LIKE', '%'.$search.'%')
                            ->with('shipping')
                            ->orderBy('id', 'DESC')
                            ->paginate($list_perpage);
            } else {
                $transactions = Transaction::where('status', $jenis_transaksi)
                            // ->with('shipping')
                            ->orderBy('id', 'DESC')
                            ->paginate($list_perpage);
            }

            return view('admin.shipping.table-data', compact('transactions'));
        }
    }

    public function getKurir()
    {
        $kurir = User::where('status', '!=', 9)
                ->where('level_id', 6)
                ->orderBy('name', 'ASC')
                ->get();

        return response()->json([
            'success' => true,
            'data' => $kurir
        ], 200);
    }

    public function getTransactions($id)
    {
        $transaction = Transaction::where('id', $id)->with('shipping')->first();

        if (!empty($transaction)) {
            return response()->json([
                'success' => true,
                'data' => $transaction
            ], 200);
        }

        return response()->json([
            'error'   => true,
            'message' => 'Gagal mengambil data transaksi dari database. Silahkan refresh table.'
        ], 404);
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
        if ($this->authorize('MOD1208-create')) {
            $rules = [
                'transaction_id' => 'required',
                'user_id'        => 'required',
                'tanggal_kirim'  => 'required|date',
            ];

            $pesan = [
                'transaction_id.required' => 'Data transaksi tidak ada. Silahkan refresh table.',
                'user_id.required'        => 'Anda wajib memilih Kurir.',
                'tanggal_kirim.required'  => 'Tanggal Pengiriman wajib di isi.',
                'tanggal_kirim.date'      => 'Tanggal Pengiriman menggunakan format YYYY-MM-DD.'
            ];

            $validasi = Validator::make($request->all(), $rules, $pesan);

            if ($validasi->fails()) {
                return response()->json([
                    'error'   => true,
                    'message' => $validasi->errors()
                ], 422);
            }

            $shipping = Shipping::create([
                'transaction_id' => $request->transaction_id,
                'user_id'        => $request->user_id,
                'tanggal_kirim'  => $request->tanggal_kirim,
                'keterangan'     => $request->keterangan,
                'status'         => $request->status
            ]);

            $transaksi = Transaction::find($request->transaction_id);
            $transaksi->status = 4;
            $transaksi->update();

            return response()->json([
                'success' => true,
                'message' => 'Berhasil melakukan penambahan data pengiriman Barang.',
                'data'    => $shipping
            ], 200);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if ($this->authorize('MOD1208-read')) {
            // code...
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if ($this->authorize('MOD1208-edit')) {
            // code...
        }
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
        if ($this->authorize('MOD1208-update')) {
            $rules = [
                'shipping_id'    => 'required',
                'transaction_id' => 'required',
                'user_id'        => 'required',
                'tanggal_kirim'  => 'required',
            ];

            $pesan = [
                'shipping_id.required'    => 'Data Shipping tidak ada. silahkan refresh table.',
                'transaction_id.required' => 'Data transaksi tidak ada. Silahkan refresh table.',
                'user_id.required'        => 'Anda wajib memilih Kurir.',
                'tanggal_kirim.required'  => 'Tanggal Pengiriman wajib di isi.'
            ];

            $validasi = Validator::make($request->all(), $rules, $pesan);

            if ($validasi->fails()) {
                return response()->json([
                    'error'   => true,
                    'message' => $validasi->errors()
                ], 422);
            }

            $shipping = Shipping::find($request->shipping_id)->update([
                'user_id'        => $request->user_id,
                'tanggal_kirim'  => $request->tanggal_kirim,
                'keterangan'     => $request->keterangan,
                'status'         => $request->status
            ]);

            if ($request->status == 1) {
                $transaksi = Transaction::find($request->transaction_id);
                $transaksi->status = 5;
                $transaksi->update();
            } else {
                $transaksi = Transaction::find($request->transaction_id);
                $transaksi->status = 4;
                $transaksi->update();
            }

            return response()->json([
                'success' => true,
                'message' => 'Berhasil melakukan perubahan data pengiriman Barang.',
                'data'    => $shipping
            ], 200);
        }        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if ($this->authorize('MOD1208-delete')) {
            // code...
        }
    }
}
