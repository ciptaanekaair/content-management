<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RekamJejakController extends Controller
{
    public function index()
    {
        if ($this->authorize('spesial')) {
            return 'History';
        }
    }
}
