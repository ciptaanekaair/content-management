<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\DetailPerusahaan;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Storage;
use Validator;

class PenggunaPerusahaanController extends Controller
{
    public function validate(Request $request, $id)
    {
        $d_perusahaan = DetailPerusahaan::find($id);

        if (!empty($d_perusahaan)) {
            $d_perusahaan->status = $request->status;
            $d_perusahaan->update();
        }
    }
}
