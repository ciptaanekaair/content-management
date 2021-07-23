<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ProductCategory;


class ProductCategoryController extends Controller
{
    public function index()
    {
        $pCategory = ProductCategory::orderBy('created_at', 'DESC')->get();

        if ($pCategory->count() > 0) {
            $response = [
                'success' => true,
                'message' => 'Berhasil load semua category',
                'data' => $pCategory
            ];
        } else {
            $response = ['success' => true, 'message' => 'Belum ada category yang di input. Silahkan menghubungi Admin.'];
        }

        return response($response, 200);
    }

    public function show($slug)
    {
        $pCategory = ProductCategory::where('slug', $slug)->first();

        if ($pCategory->count() < 1) {
            $response = ['error' => true, 'message' => 'Error! Category yang di pilih tidak terdapat di dalam database. Harap segera hubungi Admin.'];

            return response($response, 203);
        }

        $response = [
            'success' => true, 
            'message' => 'Berhasil load data category', 
            'data' => $pCategory
        ];

        return response($response, 200);
    }

    public function search($keyword)
    {
        $pCategory = ProductCategory::where('category_name', 'LIKE', '%'.$keyword.'%')
                    ->where('status', 1)
                    ->get();

        if ($pCategory->count() > 0) {
            $response = [
                'success' => true,
                'message' => 'Produk yang sesuai dengan hasil search berhasil di tampilkan.',
                'data' => $pCategory
            ];

            return response($response, 200);
        } else {
            $response = [
                'success' => true,
                'message' => 'Pencarian tidak membuahkan hasil, silahkan ganti kata kunci pencarian.'
            ];

            return response($response, 200);
        }
    }
}
