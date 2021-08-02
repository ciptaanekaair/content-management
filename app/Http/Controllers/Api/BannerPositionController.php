<?php

namespace App\Http\Controllers\Api;

use App\Models\BannerPosition;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BannerPositionController extends Controller
{
    public function getData($id)
    {
        $position = BannerPosition::with('banners')
                    ->where('id', $id)
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
