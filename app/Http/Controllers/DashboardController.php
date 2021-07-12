<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Response;

class DashboardController extends Controller
{
    public function index()
    {
        return view('main-stisla');
    }
}
