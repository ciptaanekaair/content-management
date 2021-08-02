<?php

namespace App\Http\Controllers\Api;

use App\Models\PaymentConfirmation;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PaymentConfirmation extends Controller
{
    public function store(Request $request)
    {
        $rules = [
            'transactions_id' => 'required',
            'user_id'         => 'required',
            'images'          => 'required|image|mimes:jpg,jpeg,png|max:3048',
        ];

        $pesan = [
            
        ];
    }
}
