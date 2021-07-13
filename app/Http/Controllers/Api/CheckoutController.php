<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use Validator;
use App\Models\TransactionTemporary;
use App\Models\Transaction;
use App\Models\TransactionDetail;

class CheckoutController extends Controller
{
    /**
     * Checkout seluruh barang di keranjang
     */ 
    public function checkout(Request $request)
    {
        $rules = [
            'user_id' => 'required',
        ];

        $pesan = [
            'user_id.required' => 'Session anda telah berakhir. Login kembali agar dapat melanjutkan transaksi.'
        ];

        $validasi = Validator::make($request->all(), $rules, $pesan);

        if ($validasi->fails()) {
            return response([
                'error' => true,
                'message' => $validasi->errors()
            ], 401);
        }

        $lProduct = TransactionTemporary::where('user_id', Auth::user()->id)->get();

        if ($lProduct->isEmpty()) {
            // code...
            
        }

        $response = [];

        return response($response, 200);
    }
}
