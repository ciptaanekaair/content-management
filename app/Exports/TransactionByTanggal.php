<?php

namespace App\Exports;


use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use App\Models\Transaction;

class TransactionByTanggal implements FromView, ShouldAutoSize
{
    protected $request;

    public function __construct($tanggal)
    {
        $this->tanggal = $tanggal;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function view(): View
    {
        return view('admin.transaksi.bydate', [
            'data' => Transaction::where('status', '!=', 9)
                        ->where('status', '!=', 6)
                        ->whereDate('created_at', $this->tanggal)
                        ->get()
        ]);
    }
}
