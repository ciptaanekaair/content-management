<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Storage;
use File;
use Image;

class UploadGambarTesterController extends Controller
{
    public function store(Request $request)
    {
        $rules = [
            'gambar' => 'required|image|mimes:jpg,jpeg,png'
        ];

        $this->validate($request, $rules);

        if ($request->hasFile('gambar')) {
            $gambar    = $request->file('gambar');
            $ext       = $gambar->getClientOriginalExtension();
            $rename    = rand('ABCDEFGHIJKLMNOPQRSTUVWXYZ', '1234567890').'.'.$ext;
            $watermark = $gambar->insert('Copy Right @'.date('Y').' PT. Cipta Aneka Air.', 'center');
            $simpan    = $gambar->move('public/storage/'.$rename);

            if (!$simpan) {
                return 'false';
            }

            return 'true';
        }
    }
}
