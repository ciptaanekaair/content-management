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
        if ($this->authorize('MOD1301-read') || $this->authorize('spesial')) {
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
        if ($this->authorize('MOD1301-read') || $this->authorize('spesial')) {
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
        if ($this->authorize('MOD1301-create') || $this->authorize('spesial')) {
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
        if ($this->authorize('MOD1301-create') || $this->authorize('spesial')) {
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
        if ($this->authorize('MOD1301-read') || $this->authorize('spesial')) {
            
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
        if ($this->authorize('MOD1301-edit') || $this->authorize('spesial')) {
            $kota = Kota::find($id);

            return response()->json([
                'success' => true,
                'message' => 'Berasi mengambil data kota dari database.',
                'data'    => $kota
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
        if ($this->authorize('MOD1301-update') || $this->authorize('spesial')) {
            
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
        if ($this->authorize('MOD1301-delete') || $this->authorize('spesial')) {
            
        }
    }
}
