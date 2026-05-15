<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'date',
        'location',
        'description',
    ];

    protected $casts = [
        'date' => 'date',
    ];

    // Relasi
    public function ticketCategories()
    {
        return $this->hasMany(TicketCategory::class);
    }

    public function isOpen()
    {
        return $this->date >= now()->startOfDay();
    }

    public function totalQuota()
    {
        return $this->ticketCategories()->sum('quota');
    }

    public function totalRegistrations()
    {
        return $this->ticketCategories()
            ->withCount('registrations')
            ->get()
            ->sum('registrations_count');
    }
}