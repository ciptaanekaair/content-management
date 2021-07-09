<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    public function index()
    {
        $produk = Product::orderBy('id', 'DESC')->get();

        if ($produk->count() > 0) {

            $response = ['success' => true, 'message' => 'Data berhasil di load.', 'data' => $produk];

        } else {

            $response = ['success' => true, 'message' => 'Belum ada data barang yang di input oleh admin. Silahkan hubungi admin!'];

        }        
    }

    public function search($keyword)
    {
        $validasi = $request->validate(['keywords' => 'string']);

        $produk = Product::select('products.id', 'products.product_category_id', 'products.product_code', 'products.product_name', 'products.slug', 'products.product_description', 'products.product_images', 'products.product_price', 'products.product_stock', 'products.status')
                    ->where('product_name', 'LIKE', '%'.$keyword.'%')
                    ->where('status', 1)
                    ->get();

        if ($produk->count() > 0) {
            $response = [
                'success' => true,
                'message' => 'Produk yang sesuai dengan hasil search berhasil di tampilkan.',
                'data'    => $produk
            ];
        } else {
            $response = [
                'success' => true,
                'message' => 'Tidak ada produk yang sesuai dengan pencarian Anda.'
            ];
        }

        return response($response, 200);
    }

    public function show($slug)
    {
        $produk = Produk::where('slug', $slug)->first();

        if (!$produk) {
            $response = ['error' => 'true', 'message' => 'Error! Produk yang di pilih tidak terdapat di dalam database. Harap segera hubungi Admin.'];

            return response($response, 203);
        } else {
            $response = ['success' => 'true', 'data' => $produk];

            return response($response, 200);
        }
    }
}
