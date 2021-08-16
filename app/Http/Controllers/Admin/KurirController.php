<?php

namespace App\Http\Controllers\Admin;

use App\Models\user;
use App\Models\UserDetail;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use Storage;

class KurirController extends Controller
{
    public function index()
    {
        return view('admin.kurir.index');
    }

    public function getData(Request $request)
    {
        $search       = $request->get('search');
        $list_perpage = $request->get('list_perpage');

        if (!empty()) {
            $kurirs = User::with('userDetail')
                    ->where('status', '!=', 9)
                    ->where('level_id', 6)
                    ->where('name', 'LIKE', '%'.$search.'%')
                    ->orWhere('email', 'LIKE', '%'.$search.'%')
                    ->orderBy('id', 'DESC')
                    ->paginate($list_perpage);
        } else {
            $kurirs = User::with('userDetail')
                    ->where('status', '!=', 9)
                    ->where('level_id', 6)
                    ->where('name', 'LIKE', '%'.$search.'%')
                    ->orWhere('email', 'LIKE', '%'.$search.'%')
                    ->orderBy('id', 'DESC')
                    ->paginate($list_perpage);
        }

        return view('admin.kurir.table-data', compact('kurirs'));
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
