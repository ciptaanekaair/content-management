<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use App\Models\Transaction;

class TransactionDataExport implements FromView, ShouldAutoSize, WithColumnFormatting
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function view(): View
    {
        return view('', [
            'data' => Transaction::where('status', '!=', 9)
                        ->where('status', '!=', 6)
                        ->get()
        ]);
    }
}
