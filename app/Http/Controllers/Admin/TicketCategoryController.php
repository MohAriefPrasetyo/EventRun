<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\TicketCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class TicketCategoryController extends Controller
{
    public function index(Event $event)
    {
        Gate::authorize('admin');
        $categories = $event->ticketCategories;
        return view('admin.ticket_categories.index', compact('event', 'categories'));
    }

    public function create(Event $event)
    {
        Gate::authorize('admin');
        return view('admin.ticket_categories.create', compact('event'));
    }

    public function store(Request $request, Event $event)
    {
        Gate::authorize('admin');

        $request->validate([
            'category_name' => 'required|string|max:100',
            'price' => 'required|integer|min:0',
            'quota' => 'required|integer|min:0',
        ]);

        $event->ticketCategories()->create($request->all());

        return redirect()->route('admin.events.ticket_categories.index', $event->id)
                         ->with('success', 'Kategori tiket berhasil ditambahkan.');
    }

    public function edit(Event $event, TicketCategory $ticketCategory)
    {
        Gate::authorize('admin');
        return view('admin.ticket_categories.edit', compact('event', 'ticketCategory'));
    }

    public function update(Request $request, Event $event, TicketCategory $ticketCategory)
    {
        Gate::authorize('admin');

        $request->validate([
            'category_name' => 'required|string|max:100',
            'price' => 'required|integer|min:0',
            'quota' => 'required|integer|min:0',
        ]);

        $ticketCategory->update($request->all());

        return redirect()->route('admin.events.ticket_categories.index', $event->id)
                         ->with('success', 'Kategori tiket diupdate.');
    }

    public function destroy(Event $event, TicketCategory $ticketCategory)
    {
        Gate::authorize('admin');
        $ticketCategory->delete();
        return redirect()->route('admin.events.ticket_categories.index', $event->id)
                         ->with('success', 'Kategori tiket dihapus.');
    }
}