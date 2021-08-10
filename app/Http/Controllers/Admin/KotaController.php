<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\KotasImport;
use App\Models\Provinsi;
use App\Models\Kota;

class KotaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    { 
        if ($this->authorize('MOD1301-read')) {
            $provinsis = Provinsi::where('status', '!=', 9)
                        ->orderBy('provinsi_name', 'ASC')
                        ->get();    
            $kotas = Kota::where('status', '!=', 9)
                    ->with('provinsi')
                    ->orderBy('id', 'DESC')
                    ->paginate(10);

            return view('admin.wilayah.kota.index', compact('provinsis', 'kotas'));
        }
    }

    public function getData(Request $request)
    {
        if ($this->authorize('MOD1301-read')) {
            $search       = $request->get('search');
            $list_perpage = $request->get('list_perpage');

            if (!empty($search)) {
                $kotas = Kota::where('status', '!=', 9)
                    ->where('nama_kota', 'LIKE', '%'.$search.'%')
                    ->orderBy('id', 'DESC')
                    ->paginate($list_perpage);
            } else {
                $kotas = Kota::where('status', '!=', 9)
                        ->with('provinsi')
                        ->orderBy('id', 'DESC')
                        ->paginate($list_perpage);
            }

            return view('admin.wilayah.kota.table-data', compact('kotas'));
        }
    }

    public function importData(Request $request)
    {
        if ($this->authorize('MOD1301-create')) {
            if ($request->hasFile('file_upload')) {
                Excel::import(new KotasImport, $request->file_upload);

                return response()->json([
                    'success' => true,
                    'message' => 'Berhasil import data kota.',
                ], 200);
            }

            return response()->json([
                'error'   => true,
                'message' => 'Anda belum memilih file untuk di import.',
            ], 401);
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
        if ($this->authorize('MOD1301-create')) {
            $rules = [
                'provinsi_id' => 'required|numeric',
                'nama_kota'   => 'required',
                'status'      => 'required|numeric'
            ];

            $pesan = [
                'provinsi_id.numeric' => 'Mohon pilih provinsi dari kota yang akan di input',
                'status.numeric'      => 'Mohon pilih status dari kota yang akan di input'
            ];

            $validasi = $this->validate($request, $rules, $pesan);

            $kota = Kota::create([
                'provinsi_id' => $request->provinsi_id,
                'nama_kota'   => $request->nama_kota,
                'status'      => $request->status,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Berhasil input data kota baru.',
                'data'    => $kota
            ]);
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
        if ($this->authorize('MOD1301-read')) {
            
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
        if ($this->authorize('MOD1301-edit')) {
            $kota = Kota::find($id);

            if (!empty($kota)) {
                return response()->json([
                    'success' => true,
                    'message' => 'Berhasil mengambil data dari database.',
                    'data'    => $kota
                ], 200);
            }

            return response()->json([
                'error'   => true,
                'message' => 'Gagal mengambil data dari database.'
            ], 401);
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
        if ($this->authorize('MOD1301-update')) {
            $rules = [
                'provinsi_id' => 'required|numeric',
                'nama_kota'   => 'required',
                'status'      => 'required|numeric'
            ];

            $validasi = $this->validate($request, $rules);

            $kota = Kota::find($id);
            $kota->provinsi_id = $request->provinsi_id;
            $kota->nama_kota   = $request->nama_kota;
            $kota->status      = $request->status;
            $kota->update();

            return response()->json([
                'success' => true,
                'message' => 'Berhasil update data kota.',
                'data'    => $kota
            ]);
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
        if ($this->authorize('MOD1301-delete')) {
            $kota = Kota::find($id);

            if (!empty($kota)) {
                $kota->delete();

                return response()->json([
                    'success' => true,
                    'message' => 'Berhasil menghapus data kota dari database.'
                ], 200);
            }

            return response()->json([
                'error'   => true,
                'message' => 'Gagal mengambil data dari database.'
            ], 401);
        }
    }
}
