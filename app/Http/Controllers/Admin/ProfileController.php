<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class ProfileController extends Controller
{
    public function index()
    {
        $user = User::where('id', auth()->user()->id)
                ->with('userDetail')->first();

        return view('admin.profile.index', compact('user'));
    }

    public function updatePassword(Request $request)
    {
        // code...
    }

    public function updateProfile(Request $request)
    {
        // code...
    }

    public function updateDetail(Request $request)
    {
        // code...
    }

    public function getProfile($username)
    {
        $user = User::with('userDetail')
                ->where('id', auth()->user()->id)
                ->frist();

        return view('admin.profile.index', compact('user'));
    }
}
