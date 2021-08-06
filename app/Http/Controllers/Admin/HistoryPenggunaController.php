<?php

namespace App\Http\Controllers\Admin;

use App\Models\RekamJejak;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HistoryPenggunaController extends Controller
{
    public function index()
    {
        $history = RekamJejak::orderBy('id', 'DESC')->paginate(10);

        return view('admin.history.index', compact('history'));
    }

    public function show($id)
    {
        $history = RekamJejak::find($id);

        if (!empty($history)) {
            return response()->json([
                'success' => true,
                'message' => 'Berhasil mengambil data dari database.',
                'data'    => $history
            ]);
        }

        return response()->json([
            'error'   => true,
            'message' => 'Gagal mengambil data dari database. Silahkan refresh data.'
        ]);
    }
}
