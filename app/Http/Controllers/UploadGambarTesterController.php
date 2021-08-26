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

        // $gambar  = $request->file('gambar');
        // $ext     = $gambar->getClientOriginalExtension();
        // $rename  = 'product-images/'.rand('111', '999').'.'.$ext;
        // $buatImg = Image::make($gambar->move('public/tmp/'.$rename));

        // // insert watermark
        // $watermark = $buatImg->text('Copy Right @'.date('Y').' PT. Cipta Aneka Air.', 'center');

        // Simpan di storage
        // $simpan  = Storage::putFile('public/'.$rename);
        // $simpans = Storage::url($simpan);
        // $move = Storage::move($file, 'public/')


        $image  = $request->file('gambar');
        $ext    = $image->getClientOriginalExtension();
        $rename = rand(111111111, 999999999).'-'.date('Ymd').'.'.$ext;

        $path   = 'storage/product-images/';

        // Buat image thumbnail
        $thmbn  = Image::make($image->getRealPath());

        // Gambar asli
        $moving = $image->move($path, $rename);
        $upload = $thmbn->insert('logo.png', 'center')
                    ->save($path.$rename);

        if (!$upload) {
            return response()->json([
                'error' => true,
                'message' => 'Gagal upload file.'
            ],403);
        }

        return response()->json([
            'success' => true,
            'message' => 'Berhasil upload file',
        ], 200);
    }
}
