<?php

namespace App\Http\Controllers\Api;

use App\Models\ProductLiked;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;

class ProductLikedController extends Controller
{
    public function store(Request $request)
    {
        $rules = [
            'product_id' => 'required|numeric',
        ];

        $pesan = [
            'product_id.required' => 'Anda harus memilih produk untuk di sukai.',
            'product_id.numeric' => 'Anda harus memilih produk untuk di sukai.'
        ];

        $validasi = Validator::make($request->all(), $rules, $pesan);

        if ($validasi->fails()) {
            return response([
                'error'   => true,
                'message' => $validasi->errors()
            ], 403);
        }

        $check = $this->checkLiked(auth()->user()->id, $request->product_id);

        if ($check == true) {
            $pLiked = ProductLiked::where('user_id', auth()->user()->id)
                    ->where('product_id', $request->product_id)
                    ->first();

            $pLiked->delete();

            return response([
                'success' => true,
                'liked'   => false,
                'message' => 'Berhasil unliked product.'
            ], 200);
        }

        $pLiked = new ProductLiked;
        $pLiked->user_id    = auth()->user()->id;
        $pLiked->product_id = $request->product_id;
        $pLiked->save();

        return response([
            'success' => true,
            'liked'   => true,
            'message' => 'Berhasil like product.'
        ], 200);
    }

    public function checkLiked($pengguna_id, $produk_id)
    {
        $check = ProductLiked::where('user_id', $pengguna_id)
                ->where('product_id', $produk_id)
                ->first();

        if (!empty($check)) {
            return true;
        }

        return false;
    }
}
