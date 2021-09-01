<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\ProductImage;

class ProductController extends Controller
{
    public function index()
    {
        $produk = Product::orderBy('id', 'DESC')->get();

        if ($produk->count() > 0) {

            $response = [
                'success' => true,
                'message' => 'Data berhasil di load.',
                'data' => $produk
            ];

        } else {

            $response = ['success' => true, 'message' => 'Belum ada data barang yang di input oleh admin. Silahkan hubungi admin!'];

        }        

            return response($response, 200);
    }

    public function show($slug)
    {
        $produk = Product::where('slug', $slug)->first();
        $pImage = ProductImage::where('product_id', $produk->id)->get();

        if ($produk->count() < 1) {
            $response = ['error' => 'true', 'message' => 'Error! Produk yang di pilih tidak terdapat di dalam database. Harap segera hubungi Admin.'];

            return response($response, 203);
        } else {
            $response = ['success' => 'true', 'data' => $produk, 'image' => $pImage];

            return response($response, 200);
        }
    }

    public function searching(Request $request)
    {
        $keyword = $request->get('keyword');

        if ($keyword == '') {
            $produk = Product::select('products.id', 'products.product_category_id', 'products.product_code', 
                'products.product_name', 'products.slug', 'products.product_description', 
                'products.product_images', 'products.product_price', 'products.product_stock', 
                'products.status')
                    ->where('status', 1)
                    ->get();
        } else {
            $produk = Product::select('products.id', 'products.product_category_id', 'products.product_code', 
                'products.product_name', 'products.slug', 'products.product_description', 
                'products.product_images', 'products.product_price', 'products.product_stock', 
                'products.status')
                    ->where('product_name', 'LIKE', '%'.$keyword.'%')
                    ->orWhere('product_code', 'LIKE', '%'.$keyword.'%')
                    ->where('status', 1)
                    ->get();
        }

        if ($produk->count() > 0) {
            return response([
                'success' => true,
                'message' => 'Produk yang sesuai dengan hasil search berhasil di tampilkan.',
                'data'    => $produk
            ], 200);
        }

        return response([
            'error'   => true,
            'message' => 'Pencarian tidak membuahkan hasil, silahkan ganti kata kunci pencarian.'
        ], 404);
    }

    // POST method untuk search
    // public function search(Request $request)
    // {
    //     $keyword = $request->search;

    //     $produk = Product::select('products.id', 'products.product_category_id', 'products.product_code', 
    //             'products.product_name', 'products.slug', 'products.product_description', 
    //             'products.product_images', 'products.product_price', 'products.product_stock', 
    //             'products.status')
    //             ->where('product_name', 'LIKE', '%'.$keyword.'%')
    //             ->orWhere('product_code', 'LIKE', '%'.$keyword.'%')
    //             ->where('status', 1)
    //             ->get();

    //     if (!empty($produk)) {
    //         return response([
    //             'success' => true,
    //             'message' => 'Produk yang sesuai dengan hasil search berhasil di tampilkan.',
    //             'data'    => $produk
    //         ], 200);
    //     }

    //     return response([
    //         'error'   => true,
    //         'message' => 'Pencarian tidak membuahkan hasil, silahkan ganti kata kunci pencarian.'
    //     ], 403);

    // }
}
