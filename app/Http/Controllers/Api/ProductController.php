<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\Discount;

class ProductController extends Controller
{
    public function index()
    {
        $produk = Product::where('status', '!=', 9)
                    ->orderBy('id', 'DESC')
                    ->with('Discount')
                    ->get();

        if ($produk->count() > 0) {

            $response = [
                'success' => true,
                'message' => 'Data berhasil di load.',
                'data'    => $produk
            ];

        } else {

            $response = [
                'success' => true,
                'message' => 'Belum ada data barang yang di input oleh admin. Silahkan hubungi admin!'
            ];

        }        

            return response($response, 200);
    }

    public function index_discount()
    {
        $product = Product::whereHas('Discount')
                ->where('status', '!=', 9)
                ->orderBy('id', 'DESC')
                ->get();

        if ($product->count() > 0) {

            foreach ($product as $item) {
                $harga_awal = $item->product_price;
                $diskonan   = ($harga_awal * ($item->Discount->discount / 100));

                $item['harga_setelah_discount'] = ($harga_awal - $diskonan);
            }

            $response = [
                'success' => true,
                'message' => 'Data berhasil di load.',
                'data'    => $product
            ];
            
            return response($response, 200);
        } else {
            $response = [
                'error' => true,
                'message' => 'Belum ada data barang yang memiliki discount yang telah di input oleh admin. Silahkan hubungi admin!'
            ];
            
            return response($response, 404);
        }
    }

    public function show($slug)
    {
        $produk = Product::with('Discount')->where('slug', $slug)->first();
        $pImage = ProductImage::where('product_id', $produk->id)->get();
        $product_serupa = Product::where('product_category_id', $produk->product_category_id)
                        ->where('id', '!=', $produk->id)
                        ->orderBy('id', 'DESC')
                        ->get();

        if ($produk->count() < 1) {
            $response = ['error' => 'true', 'message' => 'Error! Produk yang di pilih tidak terdapat di dalam database. Harap segera hubungi Admin.'];

            return response($response, 203);
        }

        if (!empty($produk->Discount)) {
            $harga_awal = $produk->product_price;
            $diskonan   = ($harga_awal * ($produk->Discount->discount / 100));

            $produk['harga_setelah_discount'] = ($harga_awal - $diskonan);
        }

        $response = [
            'success'        => 'true', 
            'data'           => $produk, 
            'image'          => $pImage, 
            'product_serupa' => $product_serupa
        ];

        return response($response, 200);
    }

    public function searching(Request $request)
    {
        $keyword = $request->get('keyword');

        if ($keyword == '') {
            $produk = Product::select('products.id', 'products.product_category_id', 'products.product_code', 
                'products.product_name', 'products.slug', 'products.product_description', 
                'products.product_images', 'products.product_price', 'products.product_stock', 
                'products.status')
                    ->with('Discount')
                    ->where('status', 1)
                    ->get();
        } else {
            $produk = Product::select('products.id', 'products.product_category_id', 'products.product_code', 
                'products.product_name', 'products.slug', 'products.product_description', 
                'products.product_images', 'products.product_price', 'products.product_stock', 
                'products.status')
                    ->with('Discount')
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
