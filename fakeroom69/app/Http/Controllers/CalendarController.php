<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;

class CalendarController extends Controller
{
    public function index()
    {
        $events = Event::all();
        return view('calendar.index', compact('events'));
    }

    public function store(Request $request)
    {
        // Validation for the event inputs
        $request->validate([
            'title' => 'required',
            'date' => 'required|date',
        ]);

        // Creating the event
        Event::create([
            'title' => $request->title,
            'description' => $request->description,
            'date' => $request->date,
        ]);

        // Redirecting to calendar after adding event
        return redirect()->route('calendar.index');
    }
}
