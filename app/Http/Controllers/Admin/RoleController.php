<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Role;
use App\Models\Level;

class RoleController extends Controller
{
    public function index()
    {
        $this->authorize('spesial');

        $roles  = Role::where('status', '!=', 9)
                ->paginate(10);
        $levels = Level::orderBy('nama_level', 'ASC')->get();

        return view('admin.role.index', compact('roles', 'levels'));
    }

    public function getData(Request $request)
    {
        $this->authorize('spesial');

        $search  = $request->get('search');
        $perpage = $request->get('list_perpage');

        if (!empty($search)) {
            $roles = Role::where([
                    ['status', '!=', 9],
                    ['nama_role', 'LIKE', '%'.$search.'%'],
                ])->orderBy('nama_role', 'ASC')
                ->paginate(10);
        } else {
            $roles = Role::where('status', '!=', 9)
                ->orderBy('nama_role', 'ASC')
                ->paginate(10);
        }

        return view('admin.role.table-data', compact('roles'));
    }

    public function store(Request $request)
    {
        $this->authorize('spesial');

        $rules = [
            'nama_role' => 'required|unique:roles',
            'status'    => 'required|numeric'
        ];

        $validasi = $this->validate($request, $rules);

        $roles = Role::create([
            'nama_role' => $request->nama_role,
            'status'    => $request->status
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Berhasil menambah data Role baru: '.$roles->nama_role,
            'data'    => $roles
        ]);
    }

    public function show($id)
    {
        $this->authorize('spesial');

        $roles = Role::find($id);

        return response()->json([
            'success' => true,
            'message' => 'Berhasil mengambil data dari database.',
            'data'    => $roles
        ]);
    }

    public function edit($id)
    {
        $this->authorize('spesial');

        $roles = Role::find($id);

        return response()->json([
            'success' => true,
            'message' => 'Berhasil mengambil data dari database.',
            'data'    => $roles
        ]);
    }

    public function update(Request $request, $id)
    {
        $this->authorize('spesial');

        $roles = Role::find($id);
        $roles->nama_role = $request->nama_role;
        $roles->status    = $request->status;
        $roles->update();

        return response()->json([
            'success' => true,
            'message' => 'Berhasil mengubah data roles: .'.$roles->nama_role,
            'data'    => $roles
        ]); 
    }

    public function destroy($id)
    {
        $this->authorize('spesial');

        $roles = Role::find($id);
        $roles->status = 9;
        $roles->update();

        return response()->json([
            'success' => true,
            'message' => 'Berhasil mengubah data roles: .'.$roles->nama_role,
            'data'    => $roles
        ]); 
    }
}
