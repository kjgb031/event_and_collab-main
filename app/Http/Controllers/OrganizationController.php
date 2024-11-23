<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use App\Models\EventRegistration;
use Filament\Notifications\Notification;

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

    public function eventScan(Request $request, Event $event)
    {
        $uid = $request->input('uid');

        // Find the EventRegistration by uid and event_id
        $registration = EventRegistration::where('uid', $uid)
            ->where('event_id', $event->id)
            ->first();

        return response()->json(['success' => true, 
        'student' => $registration->user
    ]);


    }

    public function eventMarkAttended(Request $request, Event $event)
    {
        $uid = $request->input('uid');

        // Find the EventRegistration by uid and event_id
        $registration = EventRegistration::where('uid', $uid)
            ->where('event_id', $event->id)
            ->first();

        if ($registration && $registration->status != EventRegistration::STATUSES['attended']) {
            // Mark as attended
            $registration->markAsAttended();

            // Send notification to the user
            Notification::make()
                ->title('You have been marked as attended')
                ->success()
                ->body("You have been marked as attended for the event: {$event->name}.")
                ->sendToDatabase($registration->user);

            return response()->json(['success' => true, 'message' => 'Attendee marked as attended.']);
        }
        return response()->json(['success' => false, 'message' => 'Invalid UID or attendee already marked as attended.'], 400);
    }
}
