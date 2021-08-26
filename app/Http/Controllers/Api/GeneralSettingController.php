<?php

namespace App\Http\Controllers\Api;

use App\Models\GeneralSetting;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class GeneralSettingController extends Controller
{
    public function index()
    {
        $gSetting = GeneralSetting::select('website_title', 'keywords', 'website_description', 'website_logo')
                    ->where('id', 1)
                    ->first();

        if (!empty($gSetting)) {
            return response([
                'success' => true,
                'data'    => $gSetting
            ], 200);
        }

        return response([
            'error'   => true,
            'message' => 'Gagal mengambil data general setting dari database.'
        ], 404);
    }
}
