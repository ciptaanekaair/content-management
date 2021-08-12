<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\UserDetail;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Storage;
use Validator;

class ProfileController extends Controller
{
    public function index()
    {
        $user = User::where('id', auth()->user()->id)
                ->with('userDetail')->first();

        return view('admin.profile', compact('user'));
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
}
