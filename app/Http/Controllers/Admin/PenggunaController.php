<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Facades\Excel;
use Storage;
use Hash;
use App\Models\User;
use App\Models\UserDetail;
use App\Models\Level;
use App\Models\Provinsi;
use App\Models\RekamJejak;
use App\Exports\PenggunaExport;

class PenggunaController extends Controller
{
    public function index()
    {
        if ($this->authorize('MOD1001-read') || $this->authorize('spesial')) {
            $users = User::where([
                    ['status', '!=', 9],
                    ['level_id', '!=', 4]
                ])->paginate(10);

            $levels    = Level::orderBy('id', 'ASC')->get();
            $provinsis = Provinsi::where('status', '!=', 9)->orderBy('provinsi_name', 'ASC')->get();

            return view('admin.users.index', compact('users', 'levels', 'provinsis'));
        }
    }

    public function getData(Request $request)
    {
        if ($this->authorize('MOD1001-read') || $this->authorize('spesial')) {

            $list_perpage = $request->get('list_perpage');
            $search       = $request->get('search');

            if (!empty($search)) {
                $users = User::where([
                    ['status', '!=', 9],
                    ['level_id', '!=', 4],
                    ['name', 'LIKE', '%'.$search.'%']
                ])->orWhere('email', 'LIKE', '%'.$search.'%')
                ->orderBy('id', 'ASC')
                ->paginate(10);
            } else {

                $users = User::where([
                    ['status', '!=', 9],
                    ['level_id', '!=', 4]
                ])->orderBy('id', 'ASC')
                ->paginate(10);
            }

            return view('admin.users.table-data', compact('users'));
        }
    }

    public function exportData()
    {
        return Excel::download(new PenggunaExport, 'data_pengguna_per-'.date('Y-m-d').'.xlsx');
    }

    public function store(Request $request)
    {
        if ($this->authorize('MOD1001-create') || $this->authorize('spesial')) {
            $rules = [
                'name'               => 'required',
                'email'              => 'required|unique:users',
                'password'           => 'required|min:6|confirmed',
                'level_id'           => 'required|numeric',
                'status'             => 'required|numeric',
                'profile_photo_path' => 'image|mimes:jpg, jpeg, png, bmp',
            ];

            $validasi = $this->validate($request, $rules);

            if ($request->hasFile('profile_photo_path')) {
                $simpan = $request->profile_photo_path->store('profile-photos', 'public');
            }

            $user = User::create([
                'name'               => $request->name,
                'email'              => $request->email,
                'username'           => md5($request->email),
                'password'           => Hash::make($request->password),
                'profile_photo_path' => $simpan,
                'level_id'           => $request->level_id,
                'status'             => $request->status
            ]);

            UserDetail::create(['user_id' => $user->id]);

            $rekam = new RekamJejak;
            $rekam->user_id     = auth()->user()->id;
            $rekam->modul_code  = '[MOD1001] users';
            $rekam->action      = 'Create';
            $rekam->description = 'User: '.auth()->user()->email.' membuat data user: '.
                                    $user->name.', dengan ID: '.$user->id.
                                    '. Pada: '.date('Y-m-d H:i:s').'.';
            $rekam->save();

            return response()->json([
                'success' => true,
                'message' => 'Berhasil menyimpan data: '.$user->email,
                'data'    => $user
            ]);
        }
    }

    public function show($id)
    {
        if ($this->authorize('MOD1001-read') || $this->authorize('spesial')) {
            $user = User::find($id);

            return response()->json([
                'success' => true,
                'message' => 'Berhasil mengambil data user dari database.',
                'data'    => $user
            ]);
        }
    }

    public function edit($id)
    {
        if ($this->authorize('MOD1001-edit') || $this->authorize('spesial')) {
            $user = User::with('userDetail')->where('id', $id)->first();

            return response()->json([
                'success' => true,
                'message' => 'Berhasil mengambil data user dari database.',
                'data'    => $user
            ]);
        }
    }

    public function update(Request $request, $id)
    {
        if ($this->authorize('MOD1001-update') || $this->authorize('spesial')) {
            $rules = [
                'name'               => 'required',
                'password'           => 'sometimes|nullable|string|min:6',
                'status'             => 'required|numeric',
                'level_id'           => 'required|numeric',
                'profile_photo_path' => 'image|mimes:jpg, jpeg, png, bmp|max: 2048',
            ];

            $validasi = $this->validate($request, $rules);

            $user = User::find($id);

            if ($request->hasFile('profile_photo_path')) {
                $simpan = $request->profile_photo_path->store('profile-photos', 'public');
                $user->profile_photo_path = $simpan;
            }

            if (empty($request->password)) {
                $user->password = Hash::make($request->password);
            }

            $name     = $user->name;
            $level_id = $user->level_id;
            $status   = $user->status;

            $user->name     = $request->name;
            $user->level_id = $request->level_id;
            $user->status   = $request->status;
            $user->update();

            $rekam = new RekamJejak;
            $rekam->user_id     = auth()->user()->id;
            $rekam->modul_code  = '[MOD1001] users';
            $rekam->action      = 'Create';
            $rekam->description = 'User: '.auth()->user()->email.' merubah data user: '.
                                    $name.' to '.$user->name.', level_id '.$level_id.' to '.$user->level_id.
                                    ', status '.$status.' to '.$user->status.', dengan ID: '.$user->id.
                                    '. Pada: '.date('Y-m-d H:i:s').'.';
            $rekam->save();

            return response()->json([
                'success' => true,
                'message' => 'Berhasil menyimpan data: '.$user->email,
                'data'    => $user
            ]);
        }
    }

    public function destroy($id)
    {
        if ($this->authorize('MOD1001-delete') || $this->authorize('spesial')) {
            $user = User::find($id);
            $user->status = 9;
            $user->update();

            $rekam = new RekamJejak;
            $rekam->user_id     = auth()->user()->id;
            $rekam->modul_code  = '[MOD1001] users';
            $rekam->action      = 'Hapus';
            $rekam->description = 'User: '.auth()->user()->email.' menghapus data user: '.
                                    $user->name.', dengan ID: '.$user->id.
                                    '. Pada: '.date('Y-m-d H:i:s').'.';
        }
    }
}
