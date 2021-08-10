<?php

namespace App\Http\Controllers\Admin;

use App\Models\Provinsi;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProvinsiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if ($this->authorize('MOD1300-read')) {
            return view('admin.wilayah.provinsi.index');
        }
    }

    public function getData(Request $request)
    {
        if ($this->authorize('MOD1300-read')) {
            $search       = $request->get('search');
            $list_perpage = $request->get('list_perpage');

            if (!empty($search)) {
                $provinsis = Provinsi::where('status', '!=', 9)
                            ->where('provinsi_name', 'LIKE', '%'.$search.'%')
                            ->orWhere('provinsi_code', 'LIKE', '%'.$search.'%')
                            ->orderBy('id', 'DESC')
                            ->paginate($list_perpage);
            } else {
                $provinsis = Provinsi::where('status', '!=', 9)
                            ->orderBy('id', 'DESC')
                            ->paginate($list_perpage);
            }

            return view('admin.wilayah.provinsi.table-data', compact('provinsis'));
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
        if ($this->authorize('MOD1300-create')) {
            $rules = [
                'provinsi_code' => 'required|string',
                'provinsi_name' => 'required|string',
                'status'        => 'required|numeric'
            ];

            $pesan = [
                'provinsi_code.required' => 'Field Kode Provinsi harus di isi.',
                'provinsi_code.string'   => 'Field Kode Provinsi harus berupa Huruf.',
                'provinsi_name.required' => 'Field Nama Provinsi harus di isi.',
                'provinsi_name.string'   => 'Field Kode Provinsi harus berupa Huruf.',
                'status.required'        => 'Field Status harus di isi.',
                'status.numeric'         => 'Field Status harus di isi.'
            ];

            $this->validate($request, $rules, $pesan);

            Provinsi::create([
                'provinsi_code' => $request->provinsi_code,
                'provinsi_name' => $request->provinsi_name,
                'status'        => $request->status
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Berhasil menambahkan data Provinsi ke dalam database.'
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
        if ($this->authorize('MOD1300-edit')) {
            $provinsi = Provinsi::find($id);

            if (!empty($provinsi)) {
                return response()->json([
                    'success' => true,
                    'message' => 'Berasil mengambil data dari database.',
                    'data'    => $provinsi
                ], 200);
            }

            return response()->json([
                'error'   => true,
                'message' => 'Gagal mengambil data dari database. Silahkan refresh table provinsi.'
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
        if ($this->authorize('MOD1300-update')) {
            $rules = [
                'provinsi_code' => 'required|string',
                'provinsi_name' => 'required|string',
                'status'        => 'required|numeric'
            ];

            $pesan = [
                'provinsi_code.required' => 'Field Kode Provinsi harus di isi.',
                'provinsi_code.string'   => 'Field Kode Provinsi harus berupa Huruf.',
                'provinsi_name.required' => 'Field Nama Provinsi harus di isi.',
                'provinsi_name.string'   => 'Field Kode Provinsi harus berupa Huruf.',
                'status.required'        => 'Field Status harus di isi.',
                'status.numeric'         => 'Field Status harus di isi.'
            ];

            $this->validate($request, $rules, $pesan);

            Provinsi::find($id)->update([
                'provinsi_code' => $request->provinsi_code,
                'provinsi_name' => $request->provinsi_name,
                'status'        => $request->status
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Berhasil merubah data Provinsi.'
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
        if ($this->authorize('MOD1300-delete')) {
            $provinsi = Provinsi::find($id);

            if (!empty($provinsi)) {
                $provinsi->status = 9;
                $provinsi->update();

                return response()->json([
                    'success' => true,
                    'message' => 'Berasil menghapus data dari database.'
                ], 200);
            }

            return response()->json([
                'error'   => true,
                'message' => 'Gagal mengambil data dari database. Silahkan refresh table provinsi.'
            ], 401);
        }
    }
}
