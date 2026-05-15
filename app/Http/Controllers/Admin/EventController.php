<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class EventController extends Controller
{
    public function index()
    {
        Gate::authorize('admin');
        $events = Event::latest()->paginate(10);
        return view('admin.events.index', compact('events'));
    }

    public function create()
    {
        Gate::authorize('admin');
        return view('admin.events.create');
    }

    public function store(Request $request)
    {
        Gate::authorize('admin');

        $request->validate([
            'name' => 'required|string|max:255',
            'date' => 'required|date',
            'location' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        Event::create($request->all());

        return redirect()->route('admin.events.index')
                         ->with('success', 'Event berhasil dibuat.');
    }

    public function edit(Event $event)
    {
        Gate::authorize('admin');
        return view('admin.events.edit', compact('event'));
    }

    public function update(Request $request, Event $event)
    {
        Gate::authorize('admin');

        $request->validate([
            'name' => 'required|string|max:255',
            'date' => 'required|date',
            'location' => 'required|string|max:255',
        ]);

        $event->update($request->all());

        return redirect()->route('admin.events.index')
                         ->with('success', 'Event berhasil diupdate.');
    }

    public function destroy(Event $event)
    {
        Gate::authorize('admin');
        $event->delete();
        return redirect()->route('admin.events.index')
                         ->with('success', 'Event dihapus.');
    }
}