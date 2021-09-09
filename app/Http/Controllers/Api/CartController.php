<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use Validator;
use App\Models\Product;
use App\Models\Discount;
use App\Models\TransactionTemporary;

class CartController extends Controller
{
    public function index()
    {
        $items = TransactionTemporary::where('user_id', Auth::user()->id)
                ->with('products.Discount')
                ->get();

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

        $hargaDiscount = 0;

        if ($this->checkDiscount($request->product_id) == true) {
            $discount      = Discount::where('product_id', $request->product_id)->first();
            $nilaiDiscount = ($discount->discount / 100);
            $hargaDiscount = ($produk->product_price * $nilaiDiscount);
        }

        // melakukan check apabila produk sudah pernah di add ke dalam cart.
        $cek_produk = TransactionTemporary::where('user_id', Auth::user()->id)
                    ->where('product_id', $request->product_id)
                    ->first();

        // jika ada produk, akan melakukan update
        if (!empty($cek_produk)) {
            $qtyAwal        = $cek_produk->qty;
            $totalPriceAwal = $cek_produk->total_price;

            $cek_produk->qty         = ($qtyAwal + $request->qty);
            $cek_produk->total_price = (($produk->product_price - $hargaDiscount) * ($qtyAwal + $request->qty));
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
        $cart->total_price = (($produk->product_price - $hargaDiscount) * $request->qty);
        $cart->save();

        $response = [
            'success' => true,
            'message' => 'Berhasil menambahkan produk ke dalam cart.',
            'data'    => $cart
        ];

        return response($response, 200);
    }

    public function handlePlus(Request $request)
    {
        // Handle tambah qty produk pada keranjang.
        $rules = [
            'user_id' => 'required',
            'cart_id' => 'required'
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response([
                'error'   => true,
                'message' => $validator->errors()
            ], 403);
        }

        $product_incart = TransactionTemporary::find($request->cart_id);

        if (!$product_incart) {
            return response([
                'error'   => true,
                'message' => 'Error! Data produk tidak ada dalam keranjang. Silahkan refresh browser Anda.'
            ], 403);
        }

        $produk = Product::find($product_incart->product_id);

        $hargaDiscount  = 0;
        $qtyAwal        = $product_incart->qty;
        $totalPriceAwal = $product_incart->total_price;

        if ($this->checkDiscount($product_incart->product_id) == true) {
            $diskon        = Discount::where('product_id', $product_incart->product_id)->first();
            $nilaiDiscount = ($diskon->discount / 100);
            $hargaDiscount = ($produk->product_price * $nilaiDiscount);
        }

        $product_incart->qty         = $qtyAwal + 1;
        $product_incart->total_price = (($produk->product_price - $hargaDiscount) * ($qtyAwal + 1));
        $product_incart->update();

        return response([
            'success' => true,
            'message' => 'Berhasil menambah quantity produk.',
            'data'    => $product_incart
        ], 200);

    }

    public function handleMinus(Request $request)
    {
        // Handle pengurangan qty produk pada keranjang.
        $rules = [
            'user_id' => 'required',
            'cart_id' => 'required'
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response([
                'error'   => true,
                'message' => $validator->errors()
            ], 403);
        }

        $product_incart = TransactionTemporary::find($request->cart_id);

        if (!$product_incart) {
            return response([
                'error'   => true,
                'message' => 'Error! Data produk tidak ada dalam keranjang. Silahkan refresh browser Anda.'
            ], 403);
        }

        $produk = Product::find($product_incart->product_id);

        // define variable untuk pengecekan qty setelah di kurangi 1.
        $qty_minus_one = $product_incart->qty - 1;

        // check hasil pengurangan qty. jika kurang dari 1, akan di hapus dari cart.
        if ($qty_minus_one < 1) {
            $product_incart->delete();

            return response([
                'success' => true,
                'message' => 'Produk telah di hapus dari cart karena jumlah quantity produk kurang dari 1.'
            ], 200);
        }

        $hargaDiscount  = 0;
        $qtyAwal        = $product_incart->qty;
        $totalPriceAwal = $product_incart->total_price;

        if ($this->checkDiscount($product_incart->product_id) == true) {
            $discount      = Discount::where('product_id', $product_incart->product_id)->first();
            $nilaiDiscount = ($discount->discount / 100);
            $hargaDiscount = ($produk->product_price * $nilaiDiscount);
        }

        $product_incart->qty         = $qtyAwal - 1;
        $product_incart->total_price = (($produk->product_price - $hargaDiscount) * ($qtyAwal - 1));
        $product_incart->update();

        return response([
            'success' => true,
            'message' => 'Berhasil mengurangi quantity produk.',
            'data' => $product_incart
        ], 200);
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

    public function checkDiscount($productID)
    {
        $check = Discount::where('product_id', $productID)->first();

        if (!empty($check)) {
            return true;
        } else {
            return false;
        }
    }
}
