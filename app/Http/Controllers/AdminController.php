<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        return view('admin.dashboard');
    }

    public function organizations()
    {
        return view('admin.organizations');
    }

    public function events()
    {
        return view('admin.events');
    }
}
