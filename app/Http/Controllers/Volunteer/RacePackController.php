<?php

namespace App\Http\Controllers\Volunteer;

use App\Http\Controllers\Controller;
use App\Models\Registration;
use App\Models\RacePack;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

class RacePackController extends Controller
{
    // Dashboard volunteer
    public function index()
    {
        Gate::authorize('volunteer');
        return view('volunteer.dashboard');
    }

    // Mencari peserta
    public function search(Request $request)
    {
        Gate::authorize('volunteer');

        $keyword = trim($request->get('q', ''));

        $query = Registration::with(['user', 'ticketCategory.event', 'racePack'])
            ->where('status', 'verified');

        if ($keyword !== '') {
            $numericId = ltrim(str_replace('REG-', '', strtoupper($keyword)), '0') ?: '0';

            $query->where(function ($q) use ($keyword, $numericId) {
                $q->whereHas('user', function ($u) use ($keyword) {
                        $u->where('name', 'LIKE', "%{$keyword}%")
                          ->orWhere('email', 'LIKE', "%{$keyword}%");
                    })
                  ->orWhere('id', $numericId);
            });
        }

        $registrations = $query->latest()->get();

        return view('volunteer.search-results', compact('registrations', 'keyword'));
    }

    // Konfirmasi serah terima race pack
    public function confirm(Registration $registration)
    {
        Gate::authorize('confirm-racepack'); // bisa juga Gate::authorize('volunteer');

        if ($registration->racePack) {
            return redirect()->back()->with('error', 'Race pack sudah diambil sebelumnya!');
        }

        DB::transaction(function () use ($registration) {
            RacePack::create([
                'registration_id' => $registration->id,
                'volunteer_id' => auth()->id(),
                'claimed_at' => now(),
            ]);

            $registration->update(['status' => 'claimed']);
        });

        return redirect()->back()->with('success', 'Race pack berhasil diserahkan.');
    }

    // Daftar peserta yang sudah lunas dan belum ambil race pack
    public function pendingPacks()
    {
        Gate::authorize('volunteer');

        $registrations = Registration::with(['user', 'ticketCategory.event'])
            ->where('status', 'verified')
            ->whereDoesntHave('racePack')
            ->latest()
            ->paginate(20);

        return view('volunteer.pending-packs', compact('registrations'));
    }
}