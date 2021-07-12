<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use Validator;
use App\Models\Product;
use App\Models\TransactionTemporary;

class CartController extends Controller
{
    public function index()
    {
        $items = TransactionTemporary::where('user_id', Auth::user()->id)->get();

        $harga_total = 0;

        if ($items->count() > 0)
        {
            foreach ($items as $item) {
                $harga_total += $item->total_price;
            }

            $response = [
                'success'     => true,
                'message'     => 'Berhasil load data Cart',
                'data'        => $items,
                'harga_total' => $harga_total
            ];
        }
        else
        {
            $response = [
                'success' => true,
                'message' => 'Belum ada produk yang dipilih. Silahkan pilih produk'
            ];
        }

        return response($response, 200);
    }

    public function store(Request $request)
    {
        // tambahkan produk kedalam cart
        $rules = [
            'user_id'    => 'required',
            'product_id' => 'required',
            'qty'        => 'required'
        ];

        $pesan = [
            'user_id.required'    => 'Anda harus login terlebih dahulu',
            'product_id.required' => 'Produk tidak berhasil di pilih. Silahkan menghubungi Admin.',
            'qty.required'        => 'Jumlah produk tidak boleh kosong!'
        ];

        $validasi = Validator::make($request->all(), $rules, $pesan);

        if ($validasi->fails()) {
            return response([
                'error'   => true,
                'message' => $validasi->errors()
            ]);
        }

        // load data produk
        $produk      = Product::findOrFail($request->product_id);

        // melakukan check apabila produk sudah pernah di add ke dalam cart.
        $cek_produk = TransactionTemporary::where('user_id', Auth::user()->id)
                    ->where('product_id', $request->product_id)
                    ->first();

        // jika ada produk, akan melakukan update
        if (!empty($cek_produk)) {

            $cek_produk->qty         += $request->qty;
            $cek_produk->total_price += ($produk->product_price * $request->qty);
            $cek_produk->update();

            $response = [
                'success' => true,
                'message' => 'Berhasil update cart.',
                'data'    => $cek_produk
            ];

            return response($response, 200);

        }

        $cart = new TransactionTemporary;
        $cart->user_id     = Auth::user()->id;
        $cart->product_id  = $request->product_id;
        $cart->qty         = $request->qty;
        $cart->total_price = $produk->product_price * $request->qty;
        $cart->save();

        $response = [
            'success' => true,
            'message' => 'Berhasil menambahkan produk ke dalam cart.',
            'data'    => $cart
        ];

        return response($response, 200);
    }

    public function updateCart(Request $request)
    {
        // mengubah data produk dalam cart
        $rules = [
            'user_id'    => 'required',
            'product_id' => 'required',
            'qty'        => 'required'
        ];

        $pesan = [
            'user_id.required'    => 'Session anda telah berakhir, silahkan melakukan login kembali.',
            'product_id.required' => 'Produk tidak berhasil di pilih. Silahkan menghubungi Admin.',
            'qty.required'        => 'Jumlah produk tidak boleh kosong!'
        ];

        $validasi = Validator::make($request->all(), $rules, $pesan);

        if ($validasi->fails()) {
            return response([
                'error'   => true,
                'message' => $validasi->errors()
            ], 403);
        }

        // load data produk
        $produk      = Product::findOrFail($request->product_id);

        // update cart sesuai dengan qty pada UI
        $cart = TransactionTemporary::where('user_id', Auth::user()->id)
                ->where('product_id', $request->product_id)
                ->first();
        $cart->qty         = $request->qty;
        $cart->total_price = $produk->product_price * $request->qty;
        $cart->update();

        $response = [
            'success' => true,
            'message' => 'Berhasil update cart.',
            'data'    => $cart
        ];

        return response($response, 200);
    }

    public function deleteCart($id)
    {
        // Hapus barang dari cart.
        $cart = TransactionTemporary::findOrFail($id);
        $cart->delete();

        $response = [
            'success' => true,
            'message' => 'Berhasil hapus produk dari Keranjang.'
        ];

        return response($response, 200);
    }
}
