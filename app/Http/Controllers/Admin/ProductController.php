<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Storage;
use Validator;

use App\Models\Product;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if ($this->authorize('MOD1104-read') || $this->authorize('spesial')) {
            $products = Product::where('status', '!=', 9)->
                        orderBy('id', 'DESC')->paginate(10);

            return view('admin.products.index', compact('products'));
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if ($this->authorize('MOD1104-create') || $this->authorize('spesial')) {
            $rules = [
                'category_product_id' => 'required',
                'product_code'        => 'required|unique:products',
                'product_name'        => 'required',
                'product_description' => 'required',
                'product_images'      => 'required|images|mimes:jpg, jpeg, png, gif, bmp',
                'product_price'       => 'required|numeric',
                'product_commision'   => 'required|numeric',
                'product_stock'       => 'required',
            ];

            $validasi = Validator::make($request->all(), $rules);

            if ($validasi->fails()) {
                return response()->json([
                    'error' => true,
                    'message' => $validasi->errors()
                ], 403);
            }


            $simpan = $request->profile_photo->storeAs('profile-photos', 'public');

            if (!$simpan) {
                return response()->json([
                    'error' => true,
                    'message' => 'Gagal mengupload file! Silahkan hubungi team developer.'
                ], 403);
            }

            $product = new Product;
            $product->category_product_id = $request->category_product_id;
            $product->product_code        = $request->product_code;
            $product->product_name        = $request->product_name;
            $product->product_description = $request->product_description;
            $product->product_images      = $simpan == '' ? 'product-images/products.png' : $simpan;
            $product->product_price       = $request->product_price;
            $product->product_commision   = $request->product_commision;
            $product->product_stock       = $request->product_stock;
            $product->save();

            return response()->json([
                'success' => true,
                'message' => 'Berhasil menyimpan data product!',
                'data'    => $product
            ], 200);

            // Note: image product harus bentuk link.

        }
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
