<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RacePack extends Model
{
    use HasFactory;

    protected $fillable = [
        'registration_id',
        'volunteer_id',
        'claimed_at',
    ];

    protected $casts = [
        'claimed_at' => 'datetime',
    ];

    // Relasi
    public function registration()
    {
        return $this->belongsTo(Registration::class);
    }

    public function volunteer()
    {
        return $this->belongsTo(User::class, 'volunteer_id');
    }
}