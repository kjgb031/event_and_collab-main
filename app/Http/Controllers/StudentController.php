<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\User;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function dashboard()
    {
        // pick 5 latest events
        $events = Event::orderBy('created_at', 'desc')
            ->where('status', 'approved')
            ->take(10)->get();

        // get 8 latest organizations
        $organizations = User::where('role', 'organization')->orderBy('created_at', 'desc')->take(8)->get();

        return view('student.dashboard', compact('events', 'organizations'));
    }

    public function events()
    {
        return view('student.events');
    }

    public function eventShow(Event $event)
    {
        if ($event->status !== 'approved') {
            abort(404);
        }
        return view('student.event-show', compact('event'));
    }

    public function eventQuery(Request $request)
    {
        // start and end
        $request->validate([
            'start' => 'required|date',
            'end' => 'required|date',
        ]);

        $events = Event::whereBetween('date', [$request->start, $request->end])
            ->where('status', 'approved')
            ->get();

        // return event object json 
        // convert name to title, date to start
        $data = [];
        foreach ($events as $event) {
            $data[] = [
                'id' => $event->id,
                'title' => $event->name,
                'start' => $event->date,
                'url' => route('student.event.show', $event),

            ];
        }
        return response()->json($data);
    }


    public function organizationShow(User $organization)
    {
        return view('student.organization-show', compact('organization'));
    }

    public function organizations()
    {
        $organizations = User::where('role', 'organization')->get();
        return view('student.organizations', compact('organizations'));
    }
}
