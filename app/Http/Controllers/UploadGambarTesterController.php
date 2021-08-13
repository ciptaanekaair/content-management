<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Storage;
use File;
use Image;
use Input;

class UploadGambarTesterController extends Controller
{
    public function index()
    {
        return view('testerupload');
    }

    public function store(Request $request)
    {
        $rules = [
            'gambar' => 'required|image|mimes:jpg,jpeg,png'
        ];

        $this->validate($request, $rules);

        if ($request->hasFile('gambar')) {
            $gambar  = $request->file('gambar');
            $ext     = $gambar->getClientOriginalExtension();
            $rename  = 'product-images/'.rand('111', '999').'.'.$ext;
            $buatImg = Image::make($gambar->getRealPath());

            // insert watermark
            $watermark = $buatImg->insert('Copy Right @'.date('Y').' PT. Cipta Aneka Air.', 'center');

            // Simpan di storage
            $simpan  = Storage::putFile('public/'.$rename);
            $simpans = Storage::url($simpan);

            if (!$simpan) {
                return response()->json([
                    'error' => true,
                    'message' => 'Gagal upload file.'
                ],403);
            }

            return response()->json([
                'success' => true,
                'message' => 'Berhasil upload file',
                'data'    => $simpans
            ], 200);
        }
    }
}
