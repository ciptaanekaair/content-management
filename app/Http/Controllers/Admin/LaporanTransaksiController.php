<?php

namespace App\Http\Controllers\Admin;

use App\Models\Transaction;
use App\Models\TransactionDetail;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Exports\TransactionByTanggal;
use App\Exports\TransaksiDateToDate;
use Excel;

class LaporanTransaksiController extends Controller
{
    public function harian()
    {
        return view('admin.laporan.bydate');
    }

    public function exportHarian(Request $request)
    {
        $tanggal   = Carbon::createFromFormat('Y-m-d', $request->from_date);
        $nama_file = 'Data transaksi harian tanggal - '.$request->from_date.'.xlsx';

        return Excel::download(new TransactionByTanggal($tanggal), $nama_file);
    }

    public function dateToDate()
    {
        return view('admin.laporan.datetodate');
    }

    public function exportDateToDate(Request $request)
    {
        $tanggal1   = Carbon::createFromFormat('Y-m-d', $request->from_date);
        $tanggal2   = Carbon::createFromFormat('Y-m-d', $request->to_date);
        $nama_file = 'Data transaksi harian tanggal ( '.$request->from_date.' - '.$request->to_date.' ).xlsx';

        return Excel::download(new TransaksiDateToDate($tanggal1, $tanggal2), $nama_file);
    }

    public function mingguan($tanggal)
    {
        return view('admin.laporan.datetodate');
    }

    public function bulanan($tanggal)
    {
        
    }
}
