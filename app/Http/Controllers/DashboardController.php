<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
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
}
