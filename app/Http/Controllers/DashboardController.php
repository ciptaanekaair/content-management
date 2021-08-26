<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Analytics;
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
    
                $userCount       = User::where('level_id', 1)->where('status', '!=', 0)->count();
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
        // last periode
        $periode1End   = Carbon::now();
        $periode1Start = Carbon::now()->subDays(6);

        $analyticsData = Analytics::fetchMostVisitedPages(Period::create($periode1Start, $periode1End), 5);

        return response()->json($analyticsData);
    }

    public function grafikChartTiga()
    {
        // last periode
        $periode1End   = Carbon::now();
        $periode1Start = Carbon::now()->subDays(6);
        // periode 2
        $periode2End   = Carbon::now()->subDays(7);
        $periode2Start = Carbon::now()->subDays(13);
        // periode 3
        $periode3End   = Carbon::now()->subDays(14);
        $periode3Start = Carbon::now()->subDays(20);
        // periode 3
        $periode4End   = Carbon::now()->subDays(21);
        $periode4Start = Carbon::now()->subDays(27);

        $analyticsEmpat = Analytics::fetchTotalVisitorsAndPageViews(Period::create($periode1Start, $periode1End));
        $analyticsTiga  = Analytics::fetchTotalVisitorsAndPageViews(Period::create($periode2Start, $periode2End));
        $analyticsDua   = Analytics::fetchTotalVisitorsAndPageViews(Period::create($periode3Start, $periode3End));
        $analyticsSatu  = Analytics::fetchTotalVisitorsAndPageViews(Period::create($periode4Start, $periode4End));

        $total_satu  = 0;
        $total_dua   = 0;
        $total_tiga  = 0;
        $total_empat = 0;

        foreach ($analyticsSatu as $value) {
            $total_satu += $value['pageViews'];
        }

        foreach ($analyticsDua as $value) {
            $total_dua += $value['pageViews'];
        }

        foreach ($analyticsTiga as $value) {
            $total_tiga += $value['pageViews'];
        }

        foreach ($analyticsEmpat as $value) {
            $total_empat += $value['pageViews'];
        }

        $totals = array($total_empat, $total_tiga, $total_dua, $total_satu);

        return response()->json(['data' => [$total_satu, $total_dua, $total_tiga, $total_empat]]);

        // $analyticsEmpat = Analytics::fetchTotalVisitorsAndPageViews(Period::days(30));
        // return response()->json($analyticsEmpat);
    }

    public function checkNeedFerify()
    {
        $countTransaksi = Transaction::where('status', 2)->count();

        return response()->json(['countTransaksi' => $countTransaksi]);
    }
}
