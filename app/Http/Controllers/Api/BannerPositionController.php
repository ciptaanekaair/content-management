<?php

namespace App\Http\Controllers\Api;

use App\Models\BannerPosition;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BannerPositionController extends Controller
{
    public function getData($posisi)
    {
        $position = BannerPosition::with('banners')
                    ->where('position_name', $posisi)
                    ->first();

        if (!empty($position)) {
            return response([
                'success' => true,
                'message' => 'Berhasil mengambil data banner dari database.',
                'data'    => $position
            ]);
        }

        return response([
            'error' => true,
            'message' => 'Gagal mengambil data dari database.'
        ]);
    }
}
