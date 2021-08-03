<?php

namespace App\Http\Controllers\Api;

use App\Models\PaymentCode;
use App\Models\PaymentConfirmation;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use Storage;

class PaymentMethodController extends Controller
{
    public function index()
    {
        $payment_code = PaymentCode::where('status', '!=', 9)->get();

        return response([
            'success' => true,
            'message' => 'Berhasil mengambil data dari database',
            'data' => $payment_code
        ]);
    }
    
    public function store(Request $request)
    {
        $rules = [
            'transactions_id' => 'required|numeric',
            'images'          => 'image|mimes:jpg,jpeg,png,pdf|max:5140',
        ];

        $pesan = [
            'transactions_id.required' => 'Data transaksi tidak di temukan. Silahkan refresh browser anda.',
            'transactions_id.numeric'  => 'Data transaksi tidak di temukan. Silahkan refresh browser anda.',
            'images.image'             => 'File harus berupa gambar',
            'images.mimes'             => 'File gambar harus berupa: jpg/jpeg/png, atau berupa PDF.',
            'images.max'               => 'Ukuran file harus tidak melebihi 5MB'
        ];

        $validasi = Validator::make($request->all(), $rules, $pesan);

        if ($validasi->fails()) {
            return response([
                'error' => true,
                'message' => $validasi->errors()
            ]);
        }

        $confirm = new PaymentConfirmation;

        if ($request->hasFile('images')) {
            $simpan = $request->images->store('');
        }

        return response([
            'success' => true,
            'message' => 'Berhasil mengajukan konfirmasi pembayaran.',
            'data'    => $payment
        ]);
    }
}
