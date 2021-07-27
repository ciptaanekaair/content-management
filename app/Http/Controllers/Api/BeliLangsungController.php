<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;

use App\Models\Product;
use App\Models\Transaction;
use App\Models\TransactionDetail;

class BeliLangsungController extends Controller
{
    public function vcrValidasi($kode)
    {
        $vcr = Voucher::where('voucher_code', $kode)->where('status', '!=', 0)->first();

        if (!$vcr) {
            return false;
        }

        $dateNow = Carbon::today();
        $dateEnd = Carbon::createFromFormat('Y-m-d H:i:s', $vcr->voucher_end);
        $check   = $dateEnd->gt($dateNow);

        $response = ['voucher_id' => $vcr->id, 'voucher_price' => $vcr->voucher_price];

        return $response;
    }

    public function store(Request $request)
    {
        $rules = [
            'user_id'    => 'required',
            'product_id' => 'required'
        ];

        $pesan = [
            'user_id.required'    => 'Anda harus login terlebih dahulu.',
            'product_id.required' => 'Gagal mengambil data produk dalam database, silahkan hubungi admin.'
        ];

        $validasi = Validator::make($request->all(), $rules, $pesan);

        if ($validasi->fails()) {
            return response([
                'error'   => true,
                'message' => $validasi->errors()
            ]);
        }

        $user_id    = $request->user_id;
        $product_id = $request->product_id;
        $code_vcr   = $request->voucher_code;
        $discount   = 0;

        $transaksi   = new Transaction;
        $product     = Product::find($product_id);
        $total_price = $product->product_price;

        if (!empty($code_vcr)) {
            $voucher = $this->vcrValidasi($code_vcr);

            if ($voucher != false) {
                $discount = $voucher['voucher_price'];
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
        $transaksi->save();

        $transaksi_id = $transaksi->id;

        TransactionDetail::create([
            'transactions_id' => $transaksi_id,
            'product_id'      => $item->product_id,
            'qty'             => $item->qty,
            'total_price'     => $item->total_price,
        ]);

        return response([
            'success' => true,
            'message' => 'Berhasil checkout! Silahkan lakukan pembayaran dan konfirmasikan pembayaran anda.',
            'data' => $transaksi
        ]);
    }
}
