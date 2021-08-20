<?php

namespace App\Http\Controllers\Admin;

use App\Models\RekamJejak;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RekamJejakController extends Controller
{
    public function index()
    {
        if ($this->authorize('spesial')) {
            return view('admin.history.index');
        }
    }

    public function getData(Request $request)
    {
        $search       = $request->get('search');
        $list_perpage = $request->get('list_perpage');

        if (!empty($search)) {
            $rekamJejaks  = RekamJejak::with('user')
                        ->where('modul_code', 'LIKE', '%'.$search.'%')
                        ->orderBy('id', 'DESC')
                        ->paginate($list_perpage);
        } else {
            $rekamJejaks  = RekamJejak::with('user')
                        ->orderBy('id', 'DESC')
                        ->paginate($list_perpage);
        }

        return view('admin.history.table-data', compact('rekamJejaks'));
    }

    public function show($id)
    {
        $history = RekamJejak::where('id', $id)
                ->with('user')
                ->first();

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
