<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TransactionTemporary;

class CartController extends Controller
{
    public function index()
    {
        $items = TransactionTemporary::where('user_id', Auth::user()->id)->get();

        if ($cart->count() > 0) 
        {
            $reponse = [
                'success' => true,
                'message' => 'Berhasil load data Cart',
                'data'    => $items
            ];
        }
        else
        {
            $response = [
                'success' => true,
                'message' => 'Belum ada produk yang dipilih. Silahkan pilih produk'
            ];
        }

        return response($response, 200);
    }

    public function store(Request $request, $id)
    {
        
    }
}
