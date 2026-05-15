<?php

namespace App\Http\Controllers\Participant;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\TicketCategory;
use App\Models\Registration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

class RegistrationController extends Controller
{
    public function selectEvent()
    {
        Gate::authorize('participant');
        $events = Event::where('date', '>=', now())->get();
        return view('participant.select-event', compact('events'));
    }

    public function selectCategory(Event $event)
    {
        Gate::authorize('participant');
        $categories = $event->ticketCategories;
        return view('participant.select-category', compact('event', 'categories'));
    }

    public function checkout(Request $request)
    {
        Gate::authorize('participant');

        $request->validate(['ticket_category_id' => 'required|exists:ticket_categories,id']);

        $category = TicketCategory::findOrFail($request->ticket_category_id);

        DB::transaction(function () use ($category) {
            $category = TicketCategory::lockForUpdate()->find($category->id);
            
            $registeredCount = Registration::where('ticket_category_id', $category->id)
                ->whereNotIn('status', ['cancelled'])
                ->count();
            
            if ($registeredCount >= $category->quota) {
                throw new \Exception('Kuota tiket sudah penuh.');
            }

            Registration::create([
                'user_id' => auth()->id(),
                'ticket_category_id' => $category->id,
                'status' => 'pending',
            ]);
        });

        return redirect()->route('participant.registrations.index')
                         ->with('success', 'Pendaftaran berhasil. Silakan upload bukti pembayaran.');
    }

    public function index()
    {
        Gate::authorize('participant');

        $registrations = Registration::with(['ticketCategory.event', 'racePack'])
            ->where('user_id', auth()->id())
            ->latest()
            ->get();

        return view('participant.registrations', compact('registrations'));
    }

    public function uploadForm(Registration $registration)
    {
        Gate::authorize('participant');
        // Pastikan milik sendiri dan status pending
        if ($registration->user_id !== auth()->id() || $registration->status !== 'pending') {
            abort(403, 'Tidak dapat mengupload bukti untuk pendaftaran ini.');
        }
        return view('participant.upload-proof', compact('registration'));
    }

    public function uploadProof(Request $request, Registration $registration)
    {
        Gate::authorize('participant');

        if ($registration->user_id !== auth()->id() || $registration->status !== 'pending') {
            abort(403);
        }

        $request->validate([
            'payment_proof' => 'required|image|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        $path = $request->file('payment_proof')->store('payment_proofs', 'public');

        $registration->update([
            'payment_proof' => $path,
            'status' => 'waiting_verification',
        ]);

        return redirect()->route('participant.registrations.index')
                         ->with('success', 'Bukti pembayaran terkirim. Menunggu verifikasi admin.');
    }

    public function downloadTicket(Registration $registration)
    {
        Gate::authorize('participant');

        if ($registration->user_id !== auth()->id() || $registration->status !== 'verified') {
            abort(403, 'E-Ticket hanya tersedia setelah pembayaran diverifikasi.');
        }

        return response()->download(storage_path('app/' . $registration->eticket_path));
    }

    public function cancel(Registration $registration)
    {
        Gate::authorize('participant');

        if ($registration->user_id !== auth()->id() || $registration->status !== 'pending') {
            return redirect()->back()->with('error', 'Hanya pendaftaran dengan status pending yang bisa dibatalkan.');
        }

        $registration->delete();

        return redirect()->route('participant.registrations.index')
                         ->with('success', 'Pendaftaran dibatalkan.');
    }
}