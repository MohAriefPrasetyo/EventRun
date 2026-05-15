<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TicketCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'event_id',
        'category_name',
        'price',
        'quota',
    ];

    // Relasi
    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    public function registrations()
    {
        return $this->hasMany(Registration::class);
    }

    // Helper: hitung sisa kuota
    public function getAvailableQuota()
    {
        $registeredCount = $this->registrations()
            ->whereNotIn('status', ['cancelled'])
            ->count();
        
        return $this->quota - $registeredCount;
    }

    // Helper: cek apakah kuota masih tersedia
    public function isQuotaAvailable()
    {
        return $this->getAvailableQuota() > 0;
    }
}