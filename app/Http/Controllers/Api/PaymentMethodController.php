<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PaymentCode;

class PaymentMethodController extends Controller
{
    
    public function store()
    {
        $payment = PaymentCode::where('status', '!=', 9)
                ->orderBy('kode_pembayaran', 'ASC')
                ->get();

        return response([
            'success' => true,
            'message' => 'Berhasil mengambil data dari database.',
            'data'    => $payment
        ]);
    }
}
