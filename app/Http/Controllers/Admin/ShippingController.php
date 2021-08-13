<?php

namespace App\Http\Controllers\Admin;

use App\Models\Shipping;
use App\Models\Transaction;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ShippingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $shippings = Transaction::where('status', '!=', 9)
                    ->orderBy('id', 'DESC')
                    ->paginate(10);

        return view('admin.shipping.index', compact('shippings'));
    }

    public function getData(Request $request)
    {
        $search       = $request->get('search');
        $list_perpage = $request->get('list_perpage');

        if (!empty($search)) {
            $shippings = Shipping::where('status', '!=', 9)
                        ->where('status', '!=', 0)
                        ->where('status', '!=', 2)
                        ->where('status', '!=', 6)
                        ->where('transaction_code', 'LIKE', '%'.$search.'%')
                        ->with('shipping')
                        ->orderBy('id', 'DESC')
                        ->paginate(10);
        } else {
            $shippings = Shipping::where('status', '!=', 9)
                        ->where('status', '!=', 0)
                        ->where('status', '!=', 2)
                        ->where('status', '!=', 6)
                        ->with('shipping')
                        ->orderBy('id', 'DESC')
                        ->paginate(10);
        }

        return view('admin.shipping.table-data', compact('shippings'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
