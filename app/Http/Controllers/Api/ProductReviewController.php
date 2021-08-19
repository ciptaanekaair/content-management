<?php

namespace App\Http\Controllers\Api;

use App\Models\Transaction;
use App\Models\ProductReview;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use Storage;

class ProductReviewController extends Controller
{
    public function store(Request $request)
    {
        $rules = [
            'transaction_id' => 'required',
            'product_id'     => 'required',
            'stars'          => 'required'
        ];

        $pesan = [
            'transaction_id.required' => 'Sepertinya Anda belum pernah bertransaksi product ini.',
            'product_id.required'     => 'Anda harus memilih produk.',
            'stars.required'          => 'Anda harus memberikan rating bintang.'
        ];

        $validasi = Validator::make($request->all(), $rules, $pesan);

        if ($validasi->fails()) {
            return response([
                'error'   => true,
                'message' => $validasi->fails()
            ]);
        }

        if ($this->checkReview($request->transaction_id, $request->product_id) == false) {
            return response([
                'error'   => true,
                'message' => 'Anda sudah pernah melakukan review untuk transaksi ini.'
            ]);
        }

        $review = ProductReview::create([
            'user_id'        => auth()->user()->id,
            'transaction_id' => $request->transaction_id,
            'stars'          => $request->stars,
            'detail_review'  => $request->detail_review,
            'status'         => 0
        ]);

        return response([
            'success' => true,
            'message' => 'Berhasil melakukan review.',
            'data'    => $review
        ]);
    }

    private function checkReview($transaction_id, $product_id)
    {
        $check = ProductReview::where('user_id', auth()->user()->id)
                            ->where('transaction_id', $transaction_id)
                            ->where('product_id', $product_id)
                            ->first();

        if (!empty($check)) {
            return false;
        }

        return true;
    }
}