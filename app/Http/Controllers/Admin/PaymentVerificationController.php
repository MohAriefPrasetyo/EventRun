<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Registration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

class PaymentVerificationController extends Controller
{
    public function index()
    {
        Gate::authorize('admin');

        $registrations = Registration::with(['user', 'ticketCategory.event'])
            ->where('status', 'waiting_verification')
            ->latest()
            ->paginate(20);

        return view('admin.payments.index', compact('registrations'));
    }

    public function approve(Registration $registration)
    {
        Gate::authorize('admin');

        DB::transaction(function () use ($registration) {
            $registration->update([
                'status' => 'verified',
                'verified_at' => now(),
            ]);

            $registration->generateETicket(); // method di model
        });

        return redirect()->back()->with('success', 'Pembayaran disetujui, E-Ticket telah diterbitkan.');
    }

    public function reject(Request $request, Registration $registration)
    {
        Gate::authorize('admin');

        $request->validate(['reason' => 'nullable|string']);

        $registration->update([
            'status' => 'pending',
            'payment_proof' => null,
        ]);

        return redirect()->back()->with('warning', 'Pembayaran ditolak. Peserta harus upload ulang.');
    }
}