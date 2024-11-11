<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;

class OrganizationController extends Controller
{
    public function dashboard()
    {
        return view('org.dashboard');
    }

    public function eventShow(Event $event)
    {
        return view('org.event-show', compact('event'));
    }
}
