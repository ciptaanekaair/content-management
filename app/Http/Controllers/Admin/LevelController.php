<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Level;

class LevelController extends Controller
{
    public function index()
    {
        $this->authorize('spesial');

        $levels = Level::where('status', '!=', 9)
                ->paginate(10);

        return view('admin.level.index', compact('levels'));
    }

    public function getData(Request $request)
    {
        $this->authorize('spesial');

        $search  = $request->get('search');
        $perpage = $request->get('list_perpage');

        if (!empty($search)) {
            $levels = Level::where([
                    ['status', '!=', 9],
                    ['nama_level', 'LIKE', '%'.$search.'%'],
                ])->orderBy('nama_level', 'ASC')
                ->paginate($perpage);
        } else {
            $levels = Level::where([
                    ['status', '!=', 9],
                    ['nama_level', 'LIKE', '%'.$search.'%'],
                ])->orderBy('nama_level', 'ASC')
                ->paginate($perpage);
        }

        return view('admin.level.table-data', compact('levels'));
    }

    public function store(Request $request)
    {
        $this->authorize('spesial');
    }

    public function show($id)
    {
        $this->authorize('spesial');
    }

    public function edit($id)
    {
        $this->authorize('spesial');
    }

    public function update(Request $request, $id)
    {
        $this->authorize('spesial');
    }

    public function destroy($id)
    {
        $this->authorize('spesial');
    }
}
