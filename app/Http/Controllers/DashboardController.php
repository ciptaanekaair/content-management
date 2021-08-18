<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Spatie\Analytics\Period;
use Auth;
use Response;
use Redirect;

use App\Models\User;
use App\Models\Product;
use App\Models\Transaction;

class DashboardController extends Controller
{
    public function index()
    {
        if (auth()->user()->level_id != 1)
        {
            if ($this->authorize('MOD1001-read')) {
    
                $userCount       = User::where('status', '!=', 0)->count();
                $productCount    = Product::where('status', '!=', 0)->count();
                $trnsctCount     = Transaction::where('status', 1)->count();
                $verifikasiBayar = Transaction::where('status', 2)->count();
                $pengemasan      = Transaction::where('status', 3)->count();
                $pengiriman      = Transaction::where('status', 3)->count();

                $currentDateTime = Carbon::now();

                $newDateTime  = array();
                $oldMonthWord = array();

                for ($i=1; $i <= 4; $i++) {
                    $oldMonthNumber[] = Carbon::now()->subMonths($i)->format('m');
                    $oldMonthWord[]   = Carbon::now()->subMonths($i)->format('M');
                }
    
                return view('main-stisla', compact(
                    'userCount', 
                    'productCount', 
                    'trnsctCount', 
                    'verifikasiBayar', 
                    'pengemasan', 
                    'pengiriman', 
                    'oldMonthNumber', 
                    'oldMonthWord'
                ));
            }
        }

        // Auth::logout(); # cause logout can't work, langsung flus() session browser.
        Session()->flush();

        return Redirect::to('https://filterpedia.co.id');
    }

    public function gotoLogin()
    {
        return redirect()->route('login');
    }

    public function grafikChartSatu($today = null, $scheduleMonths = 4)
    {
        $currentMonth = Carbon::now()->format('m');
        $currentYear  = Carbon::now()->format('Y');

        $newDateTime    = array();
        $oldMonthWord   = array();
        $totalTransaksi = array();

        for ($i=2; $i > 0; $i--) {
            $oldMonth         = Carbon::now()->subMonths($i)->format('m');
            $totalTransaksi[] = Transaction::whereYear('transaction_date', $currentYear)
                                ->whereMonth('transaction_date', $oldMonth)
                                ->where('status', '!=', 9)
                                ->where('status', '!=', 0)
                                ->where('status', '!=', 2)
                                ->where('status', '!=', 6)
                                ->sum('sub_total_price');

            $oldMonthWord[]   = Carbon::now()->subMonths($i)->format('M');
        }

        $oldMonthWord[2]       = Carbon::now()->subMonths($i)->format('M');
        $totalTransaksi[2]  = Transaction::whereYear('transaction_date', $currentYear)
                                ->whereMonth('transaction_date', $currentMonth)
                                ->where('status', '!=', 9)
                                ->where('status', '!=', 0)
                                ->where('status', '!=', 2)
                                ->where('status', '!=', 6)
                                ->sum('sub_total_price');

        $maxValue = max($totalTransaksi);

        return response()->json([
            'total_transaksi' => $totalTransaksi,
            'old_month_word'  => $oldMonthWord,
            'transaksi_max'   => $maxValue
        ]);

    }

    public function grafikChartDua()
    {
        // $analyticsData = Analytics::fetchVisitorsAndPageViews(Period::days(7));
        // $analyticsData = Analytics::fetchVisitorsAndPageViews(Period::days(7));
    }
}
