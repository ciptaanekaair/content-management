<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use Image;
use Storage;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\RekamJejak;

class ProductImageController extends Controller
{
    public function getData($id)
    {
        $product = Product::with('productImages')
                    ->where('id', $id)
                    ->first();

        return view('admin.products.table-image', compact('product'));
    }

    public function store(Request $request)
    {
        $rules = [
            'product_id_i' => 'required|numeric',
            'images'       => 'required|image|mimes:jpg,jpeg,png,bmp|max:2084'
        ];

        $validasi = $this->validate($request, $rules);

        if ($request->hasFile('images')) {
            $simpan = $request->images->store('product-images', 'public');
        }

        $images = new ProductImage;
        $images->product_id = $request->product_id_i;
        $images->images     = $simpan;
        $images->save();

        $rekam = new RekamJejak;
        $rekam->user_id     = auth()->user()->id;
        $rekam->modul_code  = '[MOD1204] product-images';
        $rekam->action      = 'Create';
        $rekam->description = 'User: '.auth()->user()->email.' upload gambar untuk product dengan ID: '.
                                $images->product_id.', dengan images ID: '.$images->id.
                                '. Pada: '.date('Y-m-d H:i:s').'.';
        $rekam->save();

        return response()->json([
            'success' => true,
            'message' => 'Berhasil menambahkan gambar product.',
            'data'    => $images
        ], 200);
    }

    public function edit($id)
    {
        $images = ProductImage::find($id);

        if (!$images) {
            return response()->json([
                'error' => true,
                'message' => 'Gagal mengambil data gambar. Silahkan refresh atau hubungi Developer.',
            ], 403);
        }

        return response()->json([
            'success' => true,
            'message' => 'Berhasil mengambil data gambar.',
            'data'    => $images
        ]);
    }

    public function update(Request $request, $id)
    {
        $rules = [
            'product_id_i' => 'required|numeric',
            'images'       => 'required|image|mimes: jpg,jpeg,png,bmp|max:2048'
        ];

        $validasi = $this->validate($request, $rules);

        $data = ProductImage::find($id);

        if ($request->hasFile('images')) {
            if (Storage::exists('/public/'.$data->images)) {
                Storage::delete('/public/'.$data->images);

                $simpan = $request->images->store('product-images', 'public');
            }
        }

        $data->images = $simpan;
        $data->update();

        $rekam = new RekamJejak;
        $rekam->user_id     = auth()->user()->id;
        $rekam->modul_code  = '[MOD1204] product-images';
        $rekam->action      = 'Update';
        $rekam->description = 'User: '.auth()->user()->email.' merubah gambar untuk product dengan ID: '.
                                $data->product_id.', dengan images ID: '.$data->id.
                                '. Pada: '.date('Y-m-d H:i:s').'.';

        if (!$data) {
            return response()->json([
                'error' => true,
                'message' => 'Gagal mengambil data gambar. Silahkan refresh atau hubungi Developer.',
            ], 403);
        }
    }

    public function delete($id)
    {
        $images = ProductImage::find($id);

        if (Storage::exists('/public/'.$images->images)) {
            Storage::delete('/public/'.$images->images);
        }

        $images->delete();

        $rekam = new RekamJejak;
        $rekam->user_id     = auth()->user()->id;
        $rekam->modul_code  = '[MOD1204] product-images';
        $rekam->action      = 'Permanent Delete';
        $rekam->description = 'User: '.auth()->user()->email.' menghapus gambar untuk product dengan ID: '.
                                $images->product_id.'. Pada: '.date('Y-m-d H:i:s').'.';

        return response()->json([
            'success' => true,
            'message' => 'Data gambar berhasil di hapus dari database.'
        ], 200);
    }
}
