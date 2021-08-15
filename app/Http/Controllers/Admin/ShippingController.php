<?php

namespace App\Http\Controllers\Admin;

use App\Models\Shipping;
use App\Models\Transaction;
use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

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
            $shippings = Transaction::where('status', '!=', 9)
                        ->where('status', '!=', 0)
                        ->where('status', '!=', 2)
                        ->where('status', '!=', 6)
                        ->where('status', '!=', 7)
                        ->orderBy('id', 'DESC')
                        ->paginate(10);

            return view('admin.shipping.index', compact('shippings'));
        }
    }

    public function getData(Request $request)
    {
        if ($this->authorize('MOD1208-read')) {
            $search       = $request->get('search');
            $list_perpage = $request->get('list_perpage');

            if (!empty($search)) {
                $shippings = Transaction::where('status', 1)
                            ->where('status', 3)
                            ->where('status', 4)
                            ->where('status', 5)
                            ->where('transaction_code', 'LIKE', '%'.$search.'%')
                            ->with('shipping')
                            ->orderBy('id', 'DESC')
                            ->paginate($list_perpage);
            } else {
                $shippings = Transaction::where('status', 3)
                            // ->with('shipping')
                            ->orderBy('id', 'DESC')
                            ->paginate($list_perpage);
            }

            return view('admin.shipping.table-data', compact('shippings'));
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
                'tanggal_kirim'  => $request->tanggal_kirim->toDateString()
            ]);

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
            // code...
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
