<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Models\ProductCategory;

class ProductCategoryController extends Controller
{
    /**
     * get data index
     */
    public function index()
    {
        $pCategory = ProductCategory::where('status', 1)
                    ->orderBy('id', 'DESC')
                    ->paginate(10);

        return view('admin.products-category.index', compact('pCategory'));
    }

    /**
     * Pengambilan data menggunakan ajax.
     * untuk kebutuhan datatables.
     */
    public function getData($search, $paging)
    {
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

    /**
     * Simpan data baru.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
