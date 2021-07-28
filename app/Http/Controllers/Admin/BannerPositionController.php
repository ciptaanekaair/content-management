<?php

namespace App\Http\Controllers\Admin;

use App\Models\BannerPosition;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BannerPositionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if ($this->authorize('MOd1100-read')) {
            $b_positions = BannerPosition::where('status', '!=', 9)
                        ->orderBy('id', 'DESC')
                        ->get();

            return view('admin.banner-position.index', compact('b_positions'));
        }
    }

    public function getData(Request $request)
    {
        if ($this->authorize('MOD1100-create')) {
            $search       = $request->get('search');
            $list_perpage = $request->get('list_perpage');

            $b_positions = BannerPosition::where('status', '!=', 9)
                        ->where('position_name', '%'.$search.'%')
                        ->orderBy('id', 'DESC')
                        ->get();
        } else {
            $b_positions = BannerPosition::where('status', '!=', 9)
                        ->where('position_name', '%'.$search.'%')
                        ->orderBy('id', 'DESC')
                        ->get();
        }
        return view('admin.banner-position.table-data', compact('b_positions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if ($this->authorize('MOD1100-create')) {
            // code...
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
        if ($this->authorize('MOD1100-create')) {
            // code...
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if ($this->authorize('MOD1100-create')) {
            // code...
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
        if ($this->authorize('MOD1100-create')) {
            // code...
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
        if ($this->authorize('MOD1100-create')) {
            // code...
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
        if ($this->authorize('MOD1100-create')) {
            // code...
        }
    }
}
