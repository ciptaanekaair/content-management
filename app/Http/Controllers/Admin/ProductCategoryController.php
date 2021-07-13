<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Models\ProductCategory;

class ProductCategoryController extends Controller
{
    /**
     * Get data index.
     */
    public function index()
    {
        if ($this->authorize('MOD1004-read') || $this->authorize('spesial')) {
            $pCategory = ProductCategory::where('status', 1)
                    ->orderBy('id', 'DESC')
                    ->paginate(10);

            return view('admin.products-category.index', compact('pCategory'));
        }
    }

    /**
     * Pengambilan data menggunakan ajax.
     * untuk kebutuhan datatables.
     */
    public function getData($search, $paging)
    {
        if ($this->authorize('MOD1004-read') || $this->authorize('special')) {

            if (!empty($sarch)) {
                $pCategory = ProductCategory::where('status', 1)
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
