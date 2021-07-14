<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ProductCategory;

class ProductCategoryController extends Controller
{
    /**
     * Get data index.
     */
    public function index()
    {
        if ($this->authorize('MOD1004-read') || $this->authorize('spesial')) {
            $pCategory = ProductCategory::where('status', '!=', 9)->
                        orderBy('id', 'DESC')->paginate(10);

            return view('admin.products-category.index', compact('pCategory'));
        }
    }

    /**
     * Pengambilan data menggunakan ajax.
     * untuk kebutuhan datatables.
     */
    public function getData($paging, $search)
    {
        if ($this->authorize('MOD1004-read') || $this->authorize('special')) {

            if (!empty($sarch)) {
                $pCategory = ProductCategory::where('status', '!=', 9)
                            ->where('category_name', 'LIKE', '%'.$search.'%')
                            ->orderBy('id', 'DESC')
                            ->paginate($paging);

                return view('admin.products-category.table-data', compact('pCategory'));
            }

            $pCategory = ProductCategory::where('status', 1)
                        ->orderBy('id', 'DESC')
                        ->paginate($paging);

            return view('admin.products-category.table-data', compact('pCategory'));

        }
    }

    /**
     * Penyimpanan data Product Categories baru.
     */
    public function store(Request $request)
    {
        if ($this->authorize('MOD1004-create') || $this->authorize('spesial')) {
            $rules = [
                'category_name' => 'required',
                'status'        => 'numeric'
            ];

            $pesan = [
                'category_name.required' => 'Nama Kategori Produk wajib di isi!',
                'status.numeric'         => 'Status wajib di pilih!'
            ];

            $validasi = Validator::make($request->all(), $rules, $pesan);

            if ($validasi->fails()) {
                return response()->json([
                    'error' => true,
                    'message' => $validasi->errors()
                ], 403);
            }

            $pCategory = new ProductCategory;
            $pCategory->category_name        = $request->category_name;
            $pCategory->category_description = $request->category_description;
            $pCategory->status               = $request->status;
            $pCategory->save();

            return response()->json([
                'success' => true,
                'message' => 'Berhasl menyimpan data '.$pCategory->category_name.' sebagai Product Category baru!'
            ], 200);
        }
    }

    /**
     * Pengambilan data menggunakan ajax.
     * untuk kebutuhan perubahan data.
     */
    public function show($id)
    {
        if ($this->authorize('MOD1004-edit') || $this->authorize('spesial')) {
            $pCategory = ProductCategory::findOrFail($id);

            return response()->json([
                'success' => true,
                'message' => 'Berhasil load data product category yang di pilih.',
                'data'    => $pCategory
            ], 200);
        }
    }

    /**
     * Pengambilan data menggunakan ajax.
     * untuk kebutuhan perubahan data.
     */
    public function edit($id)
    {
        if ($this->authorize('MOD1004-edit') || $this->authorize('spesial')) {
            
        }
    }

    /**
     * Penyimpanan perubahan data Product Categories.
     */
    public function update(Request $request, $id)
    {
        if ($this->authorize('MOD1004-update') || $this->authorize('spesial')) {
            
        }
    }

    /**
     * Penyimpanan penghapusan data Product Categories.
     */
    public function destroy($id)
    {
        if ($this->authorize('MOD1004-delete') || $this->authorize('spesial')) {
            
        }
    }
}
