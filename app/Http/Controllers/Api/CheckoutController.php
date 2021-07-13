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

        $lProduct  = TransactionTemporary::where('user_id', Auth::user()->id)->get();
        $p_on_cart = $lProduct->count();

        if ($lProduct->isEmpty()) {
            $response = [
                'success' => true,
                'message' => 'Anda belum memilih product. Silahkan pilih product di halaman product.'
            ];

            return response($response, 200);
        }

        $total_price = Auth::user()->countTotalPrice();
        $pajakPPN   = $total_price * 0.1;

        $transaksi = new Transaction;
        $transaksi->user_id          = Auth::user()->id;
        $transaksi->payment_code_id  = $request->payment_code_id == '' ? '' : $request->payment_code_id;
        $transaksi->voucher_id       = $request->voucher_id == '' ? '' : $request->voucher_id;
        $transaksi->transaction_code = 'TRN-'.date('ymd').rand('000', '999');
        $transaksi->transaction_date = date('Y-m-d');
        $transaksi->total_item       = Auth::user()->countQty();
        $transaksi->total_price      = $total_price;
        $transaksi->sub_total_price  = $total_price + $pajakPPN;
        $transaksi->save();

        $response = [
            'success' => true,
            'message' => 'Berhasil checout keranjang belanja anda. Segera lakukan pembayaran, dan konfirmasi pembayaran.',
            'data'    => $transaksi
        ];

        return response($response, 200);
    }
}
