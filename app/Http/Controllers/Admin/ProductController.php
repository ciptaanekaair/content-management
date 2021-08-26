<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Facades\Excel;
use Str;
use Validator;
use Image;
use Storage;
use App\Exports\ProductDataExport;
use App\Models\ProductCategory;
use App\Models\Product;
use App\Models\RekamJejak;

class ProductController extends Controller
{
    /**
     * Halaman utama product
     */ 
    public function index()
    {
        if ($this->authorize('MOD1104-read')) {
            $products = Product::where('status', '!=', 9)->
                        orderBy('id', 'DESC')->paginate(10);
            foreach($products as $product) {
                $products->product_price = intval($product->product_price);
            }

            return view('admin.products.index', compact('products'));
        }
    }

    public function getData(Request $request)
    {
        if ($this->authorize('MOD1104-read')) {
            $perpage = $request->get('list_perpage');
            $search  = $request->get('search');

            // jika search terisi
            if (!empty($search)) {
                $products = Product::where('status', '!=', 9)
                            ->where('product_name', 'LIKE', '%'.$search.'%')
                            ->orWhere('product_code', 'LIKE', '%'.$search.'%')
                            ->orderBy('product_name', 'ASC')
                            ->paginate($perpage);
            } else {
                $products = Product::where('status', '!=', 9)
                            ->orderBy('id', 'DESC')
                            ->paginate($perpage);
            }

            return view('admin.products.table-data', compact('products'));
        }
    }

    public function exportData()
    {
        if ($this->authorize('MOD1104-read')) {
            return Excel::download(new ProductDataExport, 'products_'.date('Y-m-d').'.xlsx');
        }
    }

    public function getDetail($id)
    {
        if ($this->authorize('MOD1104-read')) {
            $product = Product::find($id);

            if (!empty($product)) {
                $product->qty_terjual = $product->countQty();
                $product->price       = number_format($product->product_price);

                return response([
                    'success' => true,
                    'message' => 'Berhasil mengambil data dari database.',
                    'data'    => $product
                ]);
            }

            return response([
                'error'   => true,
                'message' => 'Gagal mengambil data dari database. Silahkan refresh table.'
            ]);
        }
    }

    /**
     * Halaman form input data baru
     */ 
    public function create()
    {
        if ($this->authorize('MOD1104-create')) {
            $pCategory = ProductCategory::where('status', '!=', 9)->orderBy('category_name', 'ASC')->get();

            return view('admin.products.form', ['product' => new Product(), 'pCategory' => $pCategory]);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if ($this->authorize('MOD1104-create')) {
            $rules = [
                'product_category_id' => 'required',
                'product_code'        => 'required|unique:products',
                'product_name'        => 'required',
                'product_description' => 'required',
                'product_images'      => 'image|mimes:jpg, jpeg, png, gif, bmp',
                'product_price'       => 'required|numeric',
                'product_commision'   => 'required|numeric',
                'product_stock'       => 'required|numeric',
                'status'              => 'numeric'
            ];

            $validasi = $this->validate($request, $rules);

            if ($request->hasFile('product_images')) {
                // Proses upload image.
                $image  = $request->file('product_images');
                $ext    = $image->getClientOriginalExtension();
                $name   = md5(rand(111111111111, 999999999999).'-'.date('Ymd'));
                $rename = $name.'.'.$ext;

                // Persiapkan path. Path di pisah karena path2 akan ikut masuk ke record database. [$path2.$rename]
                $path1  = 'storage/';
                $path2  = 'product-images/';

                // Buat persiapan gambar.
                $thmbn  = Image::make($image->getRealPath());

                // Gambar asli
                $moving = $image->move($path1.$path2, $rename);
                $upload = $thmbn->insert('watermark-logo-big.png', 'bottom-right', 30, 30)
                            ->save($path1.$path2.$rename);
            }

            $product = new Product;
            $product->product_category_id = $request->product_category_id;
            $product->product_code        = $request->product_code;
            $product->product_name        = $request->product_name;
            $product->slug                = Str::slug($request->product_name);
            $product->product_description = $request->product_description;
            $product->product_images      = $simpan == '' ? 'product-images/blank_product.png' : $path2.$rename;
            $product->keywords            = $request->keywords;
            $product->description_seo     = $request->description_seo;
            $product->product_price       = $request->product_price;
            $product->product_commision   = $request->product_commision;
            $product->product_stock       = $request->product_stock;
            $product->status              = $request->status;
            $product->save();

            $rekam = new RekamJejak;
            $rekam->user_id     = auth()->user()->id;
            $rekam->modul_code  = '[MOD1104] products';
            $rekam->action      = 'Create';
            $rekam->description = 'User: '.auth()->user()->email.' membuat data: '.
                                    $product->product_name.', dengan ID: '.$product->id.
                                    '. Pada: '.date('Y-m-d H:i:s').'.';
            $rekam->save();

            return response()->json([
                'success' => true,
                'message' => 'Berhasil menyimpan data product!',
                'data'    => $product
            ], 200);

        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        if ($this->authorize('MOD1104-read')) {
            $product = Product::find($id);

            return response()->json([
                'success' => true,
                'message' => 'Berhasil mengambil data product dari database.',
                'data' => $product
            ]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        if ($this->authorize('MOD1104-edit')) {
            $pCategory = ProductCategory::where('status', '!=', 9)
                        ->orderBy('category_name', 'ASC')
                        ->get();
            $product   = Product::with('productImages')
                        ->where('id', $id)
                        ->first();
            // $images    = ProductImage::where('product_id', $id)->paginate();

            return view('admin.products.form', compact('pCategory', 'product'));
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        if ($this->authorize('MOD1104-update')) {
            $rules = [
                'product_category_id' => 'required',
                'product_code'        => ['required', Rule::unique('products')->ignore($id)],
                'product_name'        => 'required',
                'product_description' => 'required',
                'product_images'      => 'image|mimes:jpg, jpeg, png, gif, bmp',
                'product_price'       => 'required|numeric',
                'product_commision'   => 'required|numeric',
                'product_stock'       => 'required|numeric',
                'status'              => 'numeric'
            ];

            $validasi = $this->validate($request, $rules);

            $product = Product::find($id);
            $simpan  = '';

            if ($request->hasFile('product_images')) {
                if (Storage::exists('/public/'.$product->product_images)) {
                    Storage::delete('/public/'.$product->product_images);
                }

                // Proses upload image.
                $image  = $request->file('product_images');
                $ext    = $image->getClientOriginalExtension();
                $name   = md5(rand(111111111111, 999999999999).'-'.date('Ymd'));
                $rename = $name.'.'.$ext;

                // Persiapkan path. Path di pisah karena path2 akan ikut masuk ke record database. [$path2.$rename]
                $path1  = 'storage/';
                $path2  = 'product-images/';

                // Buat persiapan gambar.
                $thmbn  = Image::make($image->getRealPath());

                // Gambar asli
                $moving = $image->move($path1.$path2, $rename);
                $upload = $thmbn->insert('watermark-logo-big.png', 'bottom-right', 30, 30)
                            ->save($path1.$path2.$rename);

                $product->product_images = $path2.$rename;
            }

            $product->product_category_id = $request->product_category_id;
            $product->product_code        = $request->product_code;
            $product->product_name        = $request->product_name;
            $product->slug                = Str::slug($request->product_name);
            $product->product_description = $request->product_description;
            $product->keywords            = $request->keywords;
            $product->description_seo     = $request->description_seo;
            $product->product_price       = $request->product_price;
            $product->product_commision   = $request->product_commision;
            $product->product_stock       = $request->product_stock;
            $product->status              = $request->status;
            $product->update();

            $rekam = new RekamJejak;
            $rekam->user_id     = auth()->user()->id;
            $rekam->modul_code  = '[MOD1104] products';
            $rekam->action      = 'Update';
            $rekam->description = 'User: '.auth()->user()->email.' merubah data: '.
                                    $product->product_name.', dengan ID: '.$product->id.
                                    '. Pada: '.date('Y-m-d H:i:s').'.';
            $rekam->save();

            return response()->json([
                'success' => true,
                'message' => 'Berhasil merubah data product!',
                'data'    => $product
            ], 200);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        if ($this->authorize('MOD1104-delete')) {
            $product = Product::find($id);
            $product->status = 9;
            $product->update();

            $rekam = new RekamJejak;
            $rekam->user_id     = auth()->user()->id;
            $rekam->modul_code  = '[MOD1104] products';
            $rekam->action      = 'Hapus';
            $rekam->description = 'User: '.auth()->user()->email.' menghapus data: '.
                                    $product->product_name.', dengan ID: '.$product->id.
                                    '. Pada: '.date('Y-m-d H:i:s').'.';
            $rekam->save();

            return response()->json([
                'success' => true,
                'message' => 'Berhasil menghapus data: '.$product->product_name.'.',
            ], 200);
         }
    }
}
