<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use App\Models\Transaction;

class TransaksiDateToDate implements FromView, ShouldAutoSize
{
    protected $request;

    public function __construct($tanggal1, $tanggal2)
    {
        $this->tanggal1 = $tanggal1;
        $this->tanggal2 = $tanggal2;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function view(): View
    {
        return view('admin.transaksi.bydate', [
            'data' => Transaction::where('status', '!=', 9)
                        ->where('status', '!=', 6)
                        ->whereBetween('created_at', [$this->tanggal1, $this->tanggal2])
                        ->get()
        ]);
    }
}
