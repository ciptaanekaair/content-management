<?php

namespace App\Http\Controllers\Admin;

use App\Models\user;
use App\Models\UserDetail;
use App\Models\Level;
use App\Models\Provinsi;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use Storage;

class UserStaffController extends Controller
{
    public function index()
    {
        $users = User::with('userDetail')
                ->where('status', '!=', 9)
                ->orderBy('id', 'DESC')
                ->paginate(10);
        $levels    = Level::orderBy('id', 'ASC')->get();
        $provinsis = Provinsi::where('status', '!=', 9)->orderBy('provinsi_name', 'ASC')->get();

        return view('admin.user-staff.index', compact('users', 'levels', 'provinsis'));
    }

    public function getData(Request $request)
    {
        $search       = $request->get('search');
        $list_perpage = $request->get('list_perpage');
        $jenis_akun   = $request->get('jenis_akun');

        if (!empty($search)) {
            $users = User::with('userDetail')
                    ->where('status', '!=', 9)
                    ->where('level_id', $jenis_akun)
                    ->where('name', 'LIKE', '%'.$search.'%')
                    ->orWhere('email', 'LIKE', '%'.$search.'%')
                    ->orderBy('id', 'DESC')
                    ->paginate($list_perpage);
        } else {
            $users = User::with('userDetail')
                    ->where('status', '!=', 9)
                    ->where('level_id', $jenis_akun)
                    ->orderBy('id', 'DESC')
                    ->paginate($list_perpage);
        }

        return view('admin.user-staff.table-data', compact('users'));
    }

    public function create()
    {
        // 
    }

    public function store(Request $request)
    {
        // 
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
}
