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

            return response($response, 200);
    }

    public function show($slug)
    {
        $produk = Produk::where('slug', $slug)->first();

        if ($produk->count() < 1) {
            $response = ['error' => 'true', 'message' => 'Error! Produk yang di pilih tidak terdapat di dalam database. Harap segera hubungi Admin.'];

            return response($response, 203);
        } else {
            $response = ['success' => 'true', 'data' => $produk];

            return response($response, 200);
        }
    }

    public function search(Request $request, $keyword)
    {
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
                'message' => 'Pencarian tidak membuahkan hasil, silahkan ganti kata kunci pencarian'
            ];
        }

        return response($response, 200);
    }
}
