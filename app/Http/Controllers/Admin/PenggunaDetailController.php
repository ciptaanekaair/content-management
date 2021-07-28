<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\UserDetail;


class PenggunaDetailController extends Controller
{
    public function edit($id)
    {
        if ($this->authorize('MOD1001-create') || $this->authorize('spesial')) {
            $data = UserDetail::with('getUser')->where('user_id', $id)->first();

            if ($data == '') {
                $data = UserDetail::create(['user_id' => $id]);

                return response()->json([
                    'success' => true,
                    'message' => 'Berhasil mengambil data',
                    'data' => $data
                ]);
            }

            return response()->json([
                'success' => true,
                'message' => 'Berhasil mengambil data',
                'data' => $data
            ]); 
        }
    }

    public function update(Request $request, $id)
    {
        if ($this->authorize('MOD1001-create') || $this->authorize('spesial')) {
            $rules = [
                'telepon'        => 'nullable|numeric',
                'handphone'      => 'nullable|numeric',
                'kode_pos'       => 'nullable|numeric',
                'provinsi_id'    => 'nullable|numeric',
            ];

            $validasi = $this->validate($request, $rules);

            $detail = UserDetail::find($id);
            $detail->alamat      = $request->alamat;
            $detail->provinsi_id = $request->provinsi_id;
            $detail->kode_pos    = $request->kode_pos;
            $detail->telepon     = $request->telepon;
            $detail->handphone   = $request->handphone;
            $detail->update();

            return response()->json([
                'success' => true,
                'message' => 'Berhasil merubah data shipping User.',
                'data' => $request->all()
            ]);
        }
    }
}
