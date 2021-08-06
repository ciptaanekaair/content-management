<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Auth;
use Response;

use App\Models\User;
use App\Models\Product;
use App\Models\Transaction;

class DashboardController extends Controller
{
    public function index()
    {
        if ($this->authorize('MOD1001-read')) {

            $userCount    = User::where('status', '!=', 0)->count();
            $productCount = Product::where('status', '!=', 0)->count();
            $trnsctCount  = Transaction::where('status', 1)->count();

            return view('main-stisla', compact('userCount', 'productCount', 'trnsctCount'));

        }
    }

    public function gotoLogin()
    {
        return redirect()->route('login');
    }

    public function grafikChartSatu($today = null, $scheduleMonths = 4)
    {

        // $today = !is_null($today) ? Carbon::createFromFormat('Y-m-d',$today) : Carbon::now();

        // $startDate = Carbon::instance($today)->startOfMonth()->startOfWeek()->subMonth(); // start on Sunday
        // $endDate = Carbon::instance($startDate)->addMonths($scheduleMonths)->endOfMonth();
        // $endDate->addDays(6 - $endDate->dayOfWeek);

        // $epoch = Carbon::createFromTimestamp(0);
        // $firstDay = $epoch->diffInDays($startDate);
        // $lastDay = $epoch->diffInDays($endDate);

        // $week=0;
        // $monthNum = $today->month;
        // $yearNum = $today->year;
        // $prevDay = null;
        // $theDay = $startDate;
        // $prevMonth = $monthNum;

        // $data = array();

        // while ($firstDay < $lastDay) {

        //     if (($theDay->dayOfWeek == Carbon::SUNDAY) && (($theDay->month > $monthNum) || ($theDay->month == 1))) $monthNum = $theDay->month;
        //     if ($prevMonth > $monthNum) $yearNum++;

        //     $theMonth = Carbon::createFromFormat("Y-m-d",$yearNum."-".$monthNum."-01")->format('F Y');

        //     if (!array_key_exists($theMonth,$data)) $data[$theMonth] = array();
        //     if (!array_key_exists($week,$data[$theMonth])) $data[$theMonth][$week] = array(
        //         'day_range' => '',
        //     );

        //     if ($theDay->dayOfWeek == Carbon::SUNDAY) $data[$theMonth][$week]['day_range'] = sprintf("%d-",$theDay->day);
        //     if ($theDay->dayOfWeek == Carbon::SATURDAY) $data[$theMonth][$week]['day_range'] .= sprintf("%d",$theDay->day);

        //     $firstDay++;
        //     if ($theDay->dayOfWeek == Carbon::SATURDAY) $week++;
        //     $theDay = $theDay->copy()->addDay();
        //     $prevMonth = $monthNum;
        // }

        // $totalWeeks = $week;

        // return array(
        //     'startDate' => $startDate,
        //     'endDate' => $endDate,
        //     'totalWeeks' => $totalWeeks,
        //     'schedule' => $data,
        // );

        $currentDateTime = Carbon::now();

        $newDateTime = Carbon::now()->subMonths(4);


        return response([$currentDateTime, $newDateTime]);

    }
}
