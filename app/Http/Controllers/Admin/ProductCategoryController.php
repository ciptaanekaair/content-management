<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Str;
use Validator;
use Storage;
use App\Exports\ProductCategoryExport;
use App\Models\ProductCategory;
use App\Models\RekamJejak;

class ProductCategoryController extends Controller
{
    /**
     * Get data index.
     */
    public function index()
    {
        if ($this->authorize('MOD1004-read') || $this->authorize('spesial')) {
            $pCategory = ProductCategory::where('status', '!=', 9)
                        ->orderBy('id', 'DESC')
                        ->paginate(10);

            return view('admin.products-category.index', compact('pCategory'));
        }
    }

    /**
     * Pengambilan data menggunakan ajax.
     * untuk kebutuhan datatables.
     */
    public function getData(Request $request)
    {
        if ($this->authorize('MOD1004-read') || $this->authorize('special')) {

            $c_perpage = $request->get('list_perpage');
            $search    = $request->get('search');

            if (!empty($search)) {
                $pCategory = ProductCategory::where('status', '!=', 9)
                            ->where('category_name', 'LIKE', '%'.$search.'%')
                            ->orderBy('id', 'DESC')
                            ->paginate($c_perpage);
            } else {
                $pCategory = ProductCategory::where('status', '!=', 9)
                            ->orderBy('id', 'DESC')
                            ->paginate($c_perpage);
            }


            return view('admin.products-category.table-data', compact('pCategory'));
        }

    }

    public function exportData()
    {
        if ($this->authorize('MOD1004-read') || $this->authorize('spesial')) {
            return Excel::download(new ProductCategoryExport, 'product_category_'.date('Y-m-d').'.xlsx');
        }
    }

    /**
     * Penyimpanan data Product Categories baru.
     */
    public function store(Request $request)
    {
        if ($this->authorize('MOD1004-create') || $this->authorize('spesial')) {

            $rules = [
                'category_name'  => 'required',
                'category_image' => 'required|image|mimes:jpg,jpeg,png,bmp',
                'status'         => 'numeric'
            ];
 
            $pesan = [
                'category_name.required' => 'Nama Kategori Produk wajib di isi!',
                'category_name.image'    => 'File yang anda pilih, bukan gambar. Silahkan pilih file gambar.',
                'category_name.mimes'    => 'Anda hanya dapat mengupload extensi: jpg/jpeg/pnf/bmp.',
                'status.numeric'         => 'Status wajib di pilih!'
            ];

            $validasi = $this->validate($request, $rules, $pesan);
            $simpan   = '';

            if ($request->hasFile('category_image')) {
                $simpan = $request->category_image->store('category-product-images', 'public');
            }

            $pCategory = new ProductCategory;
            $pCategory->category_name        = $request->category_name;
            $pCategory->category_description = $request->category_description;
            $pCategory->slug                 = Str::slug($request->category_name, '-');
            $pCategory->keywords             = $request->keywords;
            $pCategory->description_seo      = $request->description_seo;
            $pCategory->category_image       = $simpan == '' ? '' : $simpan;
            $pCategory->status               = $request->status;
            $pCategory->save();

            $rekam = new RekamJejak;
            $rekam->user_id     = auth()->user()->id;
            $rekam->modul_code  = '[MOD1004] product-categories';
            $rekam->action      = 'Create';
            $rekam->description = 'User: '.auth()->user()->email.' membuat data: '.$pCategory->category_name.', dengan ID: '.$pCategory->id.'. Pada: '.date('Y-m-d H:i:s').'.';
            $rekam->save();

            return response()->json([
                'success' => true,
                'message' => 'Berhasl menyimpan data '.$pCategory->category_name.' sebagai Product Category baru!',
                'data'    => $pCategory
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
                'message' => 'Berhasil load data: '.$pCategory->category_name.'.',
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
            $pCategory = ProductCategory::findOrFail($id);

            return response()->json([
                'success' => true,
                'message' => 'Berhasil load data: '.$pCategory->category_name.'.',
                'data'    => $pCategory
            ], 200);
        }
    }

    /**
     * Penyimpanan perubahan data Product Categories.
     */
    public function update(Request $request, $id)
    {
        if ($this->authorize('MOD1004-update') || $this->authorize('spesial')) {
            $rules = [
                'category_name'        => 'required',
                'status'               => 'numeric'
            ];

            $pesan = [
                'category_name.required' => 'Nama Kategori Produk wajib di isi!',
                'status.numeric'         => 'Status wajib di pilih!'
            ];

            $validasi = $this->validate($request, $rules, $pesan);
            
            $pCategory = ProductCategory::findOrFail($id);

            if ($request->hasFile('category_image')) {
                if (Storage::exists('/public/'.$pCategory->category_image)) {
                    Storage::delete('/public/'.$pCategory->category_image);

                    $simpan = $request->category_image->store('category-product-images', 'public');
                    $pCategory->category_image = $simpan;
                }
            }

            // define old data
            $category_name_o        = $pCategory->category_name;
            $category_description_o = $pCategory->category_description;
            $slug_o                 = $pCategory->slug;
            $keywords               = $pCategory->keywords;
            $description_seo_o      = $pCategory->description_seo;
            $status                 = $pCategory->status;

            $pCategory->category_name        = $request->category_name;
            $pCategory->category_description = $request->category_description;
            $pCategory->slug                 = Str::slug($request->category_name, '-');
            $pCategory->keywords             = $request->keywords;
            $pCategory->description_seo      = $request->description_seo;
            $pCategory->status               = $request->status;
            $pCategory->update();

            $rekam = new RekamJejak;
            $rekam->user_id     = auth()->user()->id;
            $rekam->modul_code  = '[MOD1004] product-categories';
            $rekam->action      = 'Update';
            $rekam->description = 'User: '.auth()->user()->email.' merubah data dengan id='.$pCategory->id.
                                    ', name='.$category_name_o.', description='.$category_description_o.
                                    ', slug='.$slug_o.', keywords='.$keywords.', description_seo='.$description_seo_o.
                                    ', status='.$status.'. Menjadi : '.$request->category_name.', description='.
                                    $request->category_description.', slug='.Str::slug($request->category_name, '-').
                                    ', keywords='.$request->keywords.', '.$request->description_seo.', status='.$request->status.
                                    '. Pada: '.date('Y-m-d H:i:s').'.';
            $rekam->save();

            return response()->json([
                'success' => true,
                'message' => 'Berhasil merubah data: '.$request->category_name.'.',
                'data'    => $pCategory
            ], 200);
        }
    }

    /**
     * Penyimpanan penghapusan data Product Categories.
     */
    public function destroy($id)
    {
        if ($this->authorize('MOD1004-delete') || $this->authorize('spesial')) {

            $pCategory = ProductCategory::findOrFail($id);
            $pCategory->status = 9;
            $pCategory->update();

            $rekam = new RekamJejak;
            $rekam->user_id     = auth()->user()->id;
            $rekam->modul_code  = '[MOD1004] product-categories';
            $rekam->action      = 'Hapus';
            $rekam->description = 'User: '.auth()->user()->email.' menghapus data: '.$pCategory->category_name.'. Pada: '.date('Y-m-d H:i:s').'.';
            $rekam->save();

            return response()->json([
                'success' => true,
                'message' => 'Berhasil hapus data: '.$pCategory->category_name.'.'
            ], 200);
        }
    }
}
