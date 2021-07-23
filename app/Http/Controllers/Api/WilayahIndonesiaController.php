<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Provinsi;

class WilayahIndonesiaController extends Controller
{
    public function index()
    {
        $provinsi = Provinsi::orderBy('provinsi_name', 'ASC')->get();

        return response([
            'success' => true,
            'message' => 'Berhasil load data provinsi.',
            'data'    => $provinsi
        ]);
    }

    public function show(Request $request, $id)
    {
        $provinsi = Provinsi::with('kota')->where('id', $id)->first();

        return response([
            'success' => true,
            'message' => 'Berhasil load data profinsi dan kota',
            'data'    => $provinsi
        ]);
    }
}
