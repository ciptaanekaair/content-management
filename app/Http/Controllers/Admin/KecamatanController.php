<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Kecamatan;
use App\Models\Kota;
use App\Imports\KecamatansImport;

class KecamatanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if ($this->authorize('spesial')) {
            $kecamatans = Kecamatan::where('status', '!=', 9)
                        ->orderBy('id', 'DESC')
                        ->paginate(10);

            $kotas = Kota::orderBy('nama_kota', 'ASC')->get();

            return view('admin.wilayah.kecamatan.index', compact('kecamatans', 'kotas'));
        }
    }

    public function getData(Request $request)
    {
        $search       = $request->get('search');
        $list_perpage = $request->get('list_perpage');

        if (!empty($search)) {
            $kecamatans = Kecamatan::where('status', '!=', 9)
                        ->where('nama_kecamatan', 'LIKE', '%'.$search.'%')
                        ->orderBy('id', 'DESC')
                        ->paginate($list_perpage);
        }
        else {
            $kecamatans = Kecamatan::where('status', '!=', 9)
                        ->orderBy('id', 'DESC')
                        ->paginate($list_perpage);
        }

        return view('admin.wilayah.kecamatan.table-data', compact('kecamatans'));
    }

    public function importData(Request $request)
    {
        if ($request->hasFile('file_upload')) {
            Excel::import(new KecamatansImport, $request->file_upload);

            return response()->json([
                'success' => true,
                'message' => 'Berhasil import data kecamatan.',
            ], 200);
        }

        return response()->json([
            'error'   => true,
            'message' => 'Anda belum memilih file untuk di import.',
        ], 401);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = [
            'kota_id'        => 'required|numeric',
            'nama_kecamatan' => 'required',
            'status'         => 'required|numeric'
        ];

        $validasi = $this->validate($request, $rules);

        $kecamatan = Kecamatan::create([
            'kota_id'        => $request->kota_id,
            'nama_kecamatan' => $request->nama_kecamatan,
            'status'         => $request->status
        ]);

        return response()->json([
            'success' => true,
            'message' => 'true',
            'data'    => $kecamatan
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $kecamatan = Kecamatan::find($id);

        if (!empty($kecamatan)) {
            return response()->json([
                'success' => true,
                'message' => 'Berhasil mengambil data dari database.',
                'data'    => $kecamatan
            ], 200);
        }
       
        return response()->json([
            'error'   => true,
            'message' => 'Gagal mengambil data dari database.'
        ], 401);
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
        $rules = [
            'kota_id'        => 'required|numeric',
            'nama_kecamatan' => 'required',
            'status'         => 'required|numeric'
        ];

        $validasi = $this->validate($request, $rules);

        $kecamatan = Kecamatan::find($id);
        $kecamatan->kota_id        = $request->kota_id;
        $kecamatan->nama_kecamatan = $request->nama_kecamatan;
        $kecamatan->status         = $request->status;
        $kecamatan->update();

        return response()->json([
            'success' => true,
            'message' => 'Berhasil update data kecamatan.',
            'data'    => $kecamatan
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $kecamatan = Kecamatan::find($id);

        if (empty($kecamatan)) {
            return response()->json([
                'success' => true,
                'message' => 'Gagal mengambil data dari database.',
                'data'    => $kecamatan
            ], 401);
        }

        $kecamatan->status = 9;
        $kecamatan->update();

        return response()->json([
            'success' => true,
            'message' => 'Berhasil menghapus data dari database.'
        ], 200);
    }
}
