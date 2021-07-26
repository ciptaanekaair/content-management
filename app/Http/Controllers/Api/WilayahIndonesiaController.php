<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Provinsi;
use App\Models\Kota;
use App\Models\Kecamatan;
use App\Models\Kelurahan;

class WilayahIndonesiaController extends Controller
{
    public function provinsiIndex()
    {
        $provinsi = Provinsi::orderBy('provinsi_name', 'ASC')->get();

        return response([
            'success' => true,
            'message' => 'Berhasil load data provinsi.',
            'data'    => $provinsi
        ]);
    }

    public function provinsiShow(Request $request, $id)
    {
        $provinsi = Provinsi::with('kota')->where('id', $id)->first();

        if (!$provinsi) {
            return response([
                'error' => true,
                'message' => 'Data provinsi tidak ada. Silahkan hubungi admin.',
            ], 403);
        }

        return response([
            'success' => true,
            'message' => 'Berhasil load data profinsi dan kota',
            'data'    => $provinsi
        ]);
    }

    public function kotaIndex()
    {
        $kota = Kota::orderBy('nama_kota', 'ASC')->get();

        return response([
            'success' => true,
            'message' => 'Berhasil load data kota.',
            'data'    => $kota
        ]);
    }

    public function kotaShow(Request $request, $id)
    {
        $kota = Kota::with('kecamatan')->where('id', $id)->first();

        if (!$kota) {
            return response([
                'error' => true,
                'message' => 'Data kota tidak ada. Silahkan hubungi admin.',
            ], 403);
        }

        return response([
            'success' => true,
            'message' => 'Berhasil load data kota dan kecamatan',
            'data'    => $kota
        ]);
    }

    public function kecamatanIndex()
    {
        $kecamatan = Kecamatan::orderBy('nama_kecamatan', 'ASC')->get();

        return response([
            'success' => true,
            'message' => 'Berhasil load data kota.',
            'data'    => $kecamatan
        ]);
    }

    public function kecamatanShow(Request $request, $id)
    {
        $kecamatan = Kecamatan::with('kelurahan')->where('id', $id)->first();

        if (!$kecamatan) {
            return response([
                'error' => true,
                'message' => 'Data kecamatan tidak ada. Silahkan hubungi admin.',
            ], 403);
        }

        return response([
            'success' => true,
            'message' => 'Berhasil load data kota dan kecamatan',
            'data'    => $kecamatan
        ]);
    }

    public function kelurahanIndex()
    {
        $kelurahan = Kelurahan::orderBy('nama_kelurahan', 'ASC')->get();

        return response([
            'success' => true,
            'message' => 'Berhasil load data kota.',
            'data'    => $kelurahan
        ]);
    }

    public function kelurahanShow(Request $request, $id)
    {
        $kelurahan = Kelurahan::find($id);

        if (!$kelurahan) {
            return response([
                'error' => true,
                'message' => 'Data kelurahan tidak ada. Silahkan hubungi admin.',
            ], 403);
        }

        return response([
            'success' => true,
            'message' => 'Berhasil load data kota dan kecamatan',
            'data'    => $kelurahan
        ]);
    }
}
