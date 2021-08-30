<?php

namespace App\Http\Controllers\Admin;

use App\Models\Banner;
use App\Models\BannerPosition;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use Image;
use Storage;

class BannerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if ($this->authorize('MOD1100-read')) {
            $banners = Banner::select('banners.*', 'banner_positions.position_name')
                    ->join('banner_positions', 'banners.banner_position_id', '=', 'banner_positions.id')
                    ->orderBy('banners.id', 'DESC')
                    ->paginate(10);

            $positions = BannerPosition::orderBy('position_name', 'ASC')->get();

            return view('admin.banner.index', compact('banners', 'positions'));
        }
    }

    public function getData(Request $request)
    {
        if ($this->authorize('MOD1100-read')) {
            $search       = $request->get('search');
            $list_perpage = $request->get('list_perpage');

            if (!empty($search)) {
                $banners = Banner::select('banners.*', 'banner_positions.position_name')
                        ->join('banner_positions', 'banners.banner_position_id', '=', 'banner_positions.id')
                        ->where('banners.banner_name', 'LIKE', '%'.$search.'%')
                        ->orderBy('banners.id', 'DESC')
                        ->paginate($list_perpage);
            } else {
                $banners = Banner::select('banners.*', 'banner_positions.position_name')
                        ->join('banner_positions', 'banners.banner_position_id', '=', 'banner_positions.id')
                        ->orderBy('banners.id', 'DESC')
                        ->paginate($list_perpage);
            }

            return view('admin.banner.table-data', compact('banners'));
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if ($this->authorize('MOD1100-create')) {
            $rules = [
                'banner_position_id' => 'required|numeric',
                'banner_name'        => 'required',
                'banner_image'       => 'required|image|mimes:jpg,jpeg,png|max:5140'
            ];

            $pesan = [
                'banner_position_id.required' => 'Posisi Banner harus di pilih.',
                'banner_position_id.numeric'  => 'Posisi Banner harus di pilih.',
                'banner_name.required'        => 'Field Nama Banner wajib di isi.',
                'banner_image.required'       => 'Wajib menyertakan Gambar Banner.',
                'banner_image.image'          => 'File haruslah berupa gambar.',
                'banner_image.mimes'          => 'File haruslah berupa gambar, dengan ekstensi: JPG/JPEG/PNG.',
                'banner_image.max'            => 'File harus tidak melebihi 2MB'
            ];

            $validasi = Validator::make($request->all(), $rules, $pesan);

            if ($validasi->fails()) {
                return response()->json([
                    'error' => true,
                    'message' => $validasi->errors()
                ], 403);
            }

            if ($request->hasFile('banner_image')) {
                $simpan = $request->banner_image->store('banner-images', 'public');
            }

            $banner = Banner::create([
                'banner_position_id' => $request->banner_position_id,
                'banner_name'        => $request->banner_name,
                'banner_image'       => $simpan
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Berhasil menambahkan Gambar Banner baru.',
                'data'    => $banner
            ], 200);
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
        if ($this->authorize('MOD1100-read')) {
            $banner = Banner::find($id);

            if (!empty($banner)) {
                return response()->json([
                    'success' => true,
                    'message' => 'Berhasil mengambil data dari database.',
                    'data' => $banner
                ]);
            }

            return response()->json([
                'error' => true,
                'message' => 'Gagal mengambil data dari database. Silahkan reset table.',
            ]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if ($this->authorize('MOD1100-edit')) {
            $banner = Banner::find($id);

            if (!empty($banner)) {
                return response()->json([
                    'success' => true,
                    'message' => 'Berhasil mengambil data dari database.',
                    'data' => $banner
                ]);
            }

            return response()->json([
                'error' => true,
                'message' => 'Gagal mengambil data dari database. Silahkan reset table.',
            ]);
        }
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
        if ($this->authorize('MOD1100-update')) {
            $rules = [
                'banner_position_id'  => 'required|numeric',
                'banner_name'  => 'required',
                'banner_image' => 'image|mimes:jpg,jpeg,png|max:5140'
            ];

            $pesan = [
                'banner_position_id.required' => 'Posisi Banner harus di pilih.',
                'banner_position_id.numeric'  => 'Posisi Banner harus di pilih.',
                'banner_name.required'        => 'Field Nama Banner wajib di isi.',
                'banner_image.required'       => 'Wajib menyertakan Gambar Banner.',
                'banner_image.image'          => 'File haruslah berupa gambar.',
                'banner_image.mimes'          => 'File haruslah berupa gambar, dengan ekstensi: JPG/JPEG/PNG.',
                'banner_image.max'            => 'File harus tidak melebihi 2MB'
            ];

            $validasi = Validator::make($request->all(), $rules, $pesan);

            if ($validasi->fails()) {
                return response()->json([
                    'error' => true,
                    'message' => $validasi->errors()
                ], 403);
            }

            $banner = Banner::find($id);

            if (!empty($banner)) {
                
                if ($request->hasFile('banner_image')) {
                    if (Storage::exists('/public/'.$banner->banner_image)) {
                        Storage::delete('/public/'.$banner->banner_image);
                    }

                    $simpan               = $request->banner_image->store('banner-images', 'public');
                    $banner->banner_image = $simpan;
                }

                $banner->banner_position_id = $request->banner_position_id;
                $banner->banner_name        = $request->banner_name;
                $banner->update();

                return response()->json([
                    'success' => true,
                    'message' => 'Berhasil menambahkan Gambar Banner baru.',
                    'data'    => $banner
                ], 200);
            }

            return response()->json([
                'error' => true,
                'message' => 'Gagal mengambil data dari data base. Silahkah refresh table.'
            ], 401);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $banner = Banner::find($id);

        if (!empty($banner)) {
            if (Storage::exists('/public/'.$banner->banner_image)) {
                Storage::delete('/public/'.$banner->banner_image);
            }
        }

        $banner->delete();

        return response()->json([
            'success' => true,
            'message' => 'Berhasil hapus data banner.'
        ]);
    }
}
