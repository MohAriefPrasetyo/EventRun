<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Gate;

class DashboardController extends Controller
{
    public function admin()
    {
        Gate::authorize('admin');
        return view('dashboard.admin');
    }

    public function volunteer()
    {
        Gate::authorize('volunteer');
        return view('dashboard.volunteer');
    }

    public function participant()
    {
        Gate::authorize('participant');
        return view('dashboard.participant');
    }
}