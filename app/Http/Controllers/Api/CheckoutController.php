<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use Validator;
use Carbon\Carbon;
use App\Models\TransactionTemporary;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use App\Models\Voucher;

class CheckoutController extends Controller
{
    public function vcrValidasi($kode)
    {
        $vcr = Voucher::where('voucher_code', $kode)->first();

        if (!$vcr) {
            return false;
        }

        $dateNow = Carbon::today();
        $dateEnd = Carbon::createFromFormat('Y-m-d H:i:s', $vcr->voucher_end);
        $check   = $dateEnd->gt($dateNow);

        $response = ['voucher_id' => $vcr->id, 'voucher_price' => $vcr->voucher_price];

        return $response;
    }

    public function checkout(Request $request)
    {
        $rules = [
            'user_id' => 'required',
        ];

        $validasi = Validator::make($request->all(), $rules);

        if ($validasi->fails()) {
            return response([
                'error' => true,
                'message' => $validasi->errors()
            ], 401);
        }

        // Check ada produk dalam keranjang atau tidak
        $lProduct  = TransactionTemporary::where('user_id', Auth::user()->id)->get();
        $p_on_cart = $lProduct->count();

        if ($lProduct->isEmpty()) {
            $response = [
                'success' => true,
                'message' => 'Anda belum memilih product. Silahkan pilih product di halaman product.'
            ];

            return response($response, 200);
        }

        // devine variable baru
        $total_price = Auth::user()->countTotalPrice();
        $code_vcr    = $request->voucher_code;
        $discount    = 0;

        // buat transaksi baru
        $transaksi          = new Transaction;
        $transaksi->user_id = Auth::user()->id;

        if (!empty($request->voucher_code)) {

            $voucher  = $this->vcrValidasi($code_vcr); // check validasi voucher.

            // jika voucer ditemukan berdasarkan kode
            if ($voucher != false) {

                $discount = $voucher['voucher_price']; // variable discount

                // siapkan data voucher_id untuk masuk kedalam database.
                $transaksi->voucher_id = $voucher['voucher_id'];
            }

        }

        // buat perhitungan
        $p_after_discount = $total_price - $discount;
        $pajakPPN         = $p_after_discount * 0.1;

        $transaksi->transaction_code     = 'TRN-'.date('ymd').rand('000', '999');
        $transaksi->transaction_date     = date('Y-m-d');
        $transaksi->total_item           = Auth::user()->countQty();
        $transaksi->total_price          = $total_price;
        $transaksi->discount             = $discount;
        $transaksi->price_after_discount = $p_after_discount;
        $transaksi->pajak_ppn            = $pajakPPN;
        $transaksi->sub_total_price      = $p_after_discount + $pajakPPN;
        // $transaksi->save();

        $response = ['data' => $transaksi];


        return response($response, 200);
    }

    /**
     * Checkout seluruh barang di keranjang
     */ 
    public function checkouta(Request $request)
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
        $pajakPPN    = $total_price * 0.1;
        $discount    = 0;
        $code_vcr    = $request->voucher_code;

        // if ($request->voucher_id != '') {
        //     $voucher  = Voucher::findOrFail($request->voucher_id);
        //     $discount = $voucher->voucher_price;
        // }

        // $transaksi = new Transaction;
        // $transaksi->user_id          = Auth::user()->id;
        // $transaksi->payment_code_id  = $request->payment_code_id == '' ? NULL : $request->payment_code_id;
        // $transaksi->voucher_id       = $request->voucher_id == '' ? NULL : $request->voucher_id;
        // $transaksi->transaction_code = 'TRN-'.date('ymd').rand('000', '999');
        // $transaksi->transaction_date = date('Y-m-d');
        // $transaksi->total_item       = Auth::user()->countQty();
        // $transaksi->total_price      = $total_price;
        // $transaksi->sub_total_price  = ($total_price + $pajakPPN) - $discount;
        // $transaksi->save();

        if ($code_vcr != '') {
            $discount = $this->vcrValidasi($code_vcr);
        }

        // $response = [
        //     'success' => true,
        //     'message' => 'Berhasil checout keranjang belanja anda. Segera lakukan pembayaran, dan konfirmasi pembayaran.',
        //     'data'    => $transaksi
        // ];

        $response = [
            'voucher_id'      => $discount->id,
            'total_price'     => $total_price,
            'discount'        => $discount,
            'sub_total_price' => ($total_price + $pajakPPN) - $discount->voucher_price,
        ];

        return response($response, 200);
    }

    public function validasiVoucher(Request $request)
    {
        $vcr = Voucher::where('voucher_code', $request->voucher_code)->first();

        if (!$vcr) {
            return response(['error' => true, 'message' => 'Code voucher yang anda masukan tidak ada.'], 200);
        }

        $dateNow = Carbon::today();
        $dateEnd = Carbon::createFromFormat('Y-m-d H:i:s', $vcr->voucher_end);
        $check   = $dateEnd->gt($dateNow);

        if ($check == false) {
            return response([
                'error'   => true, 
                'message' => 'Perhatikan tanggal berlaku voucher yang anda masukan.'
            ], 403);
        }

        return response([
            'success' => true,
            'message' => 'Selamat, voucher dapat digunakan pada transaksi ini.',
            'data'    => $vcr
        ]);
    }
}
