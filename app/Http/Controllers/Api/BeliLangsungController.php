<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendInvoiceMail;
use Validator;
use Auth;
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
            'user_id'         => 'required',
            'product_id'      => 'required',
            'payment_code_id' => 'required'
        ];

        $pesan = [
            'user_id.required'    => 'Anda harus login terlebih dahulu.',
            'product_id.required' => 'Gagal mengambil data produk dalam database, silahkan hubungi admin.',
            'payment_code_id'     => 'Anda harus memilih metode pembayaran.'
        ];

        $validasi = Validator::make($request->all(), $rules, $pesan);

        if ($validasi->fails()) {
            return response([
                'error'   => true,
                'message' => $validasi->errors()
            ]);
        }

        $user_id    = auth()->user()->id;
        $product_id = $request->product_id;
        $code_vcr   = $request->voucher_code;
        $discount   = 0;

        $transaksi   = new Transaction;
        $product     = Product::find($request->product_id);

        if ($product->product_stock < 1) {
            return response([
                'error' => true,
                'message' => 'Saya sekali, product yang anda pilih sudah habis. Silahkan hubungi admin.'
            ], 401);
        }

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

        $transaksi->user_id              = $user_id;
        $transaksi->payment_code_id      = $request->payment_code_id;
        $transaksi->transaction_code     = 'TRN-'.date('ymd').rand('000', '999');
        $transaksi->transaction_date     = date('Y-m-d');
        $transaksi->total_item           = 1;
        $transaksi->total_price          = $total_price;
        $transaksi->discount             = $discount;
        $transaksi->price_after_discount = $p_after_discount;
        $transaksi->pajak_ppn            = $pajakPPN;
        $transaksi->sub_total_price      = $p_after_discount + $pajakPPN;
        $transaksi->save();

        $transaksi_id = $transaksi->id;

        TransactionDetail::create([
            'transactions_id' => $transaksi_id,
            'product_id'      => $product_id,
            'qty'             => 1,
            'total_price'     => $total_price,
        ]);

        $data = Transaction::where('id', $transaksi->id)
                ->with('transactionDetail.products')
                ->with('paymentMethod')
                ->first();

        Mail::to(Auth::user()->email)->send(new SendInvoiceMail($data));

        return response([
            'success' => true,
            'message' => 'Berhasil checkout! Silahkan lakukan pembayaran dan konfirmasikan pembayaran anda.',
            'data' => $transaksi
        ]);
    }
}
