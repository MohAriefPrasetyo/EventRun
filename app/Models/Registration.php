<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;

class Registration extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'ticket_category_id',
        'payment_proof',
        'status',
        'verified_at',
        'eticket_path',
    ];

    protected $casts = [
        'verified_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function ticketCategory()
    {
        return $this->belongsTo(TicketCategory::class);
    }

    public function racePack()
    {
        return $this->hasOne(RacePack::class);
    }

    public function isPending()
    {
        return $this->status === 'pending';
    }

    public function isWaitingVerification()
    {
        return $this->status === 'waiting_verification';
    }

    public function isVerified()
    {
        return $this->status === 'verified';
    }

    public function isClaimed()
    {
        return $this->status === 'claimed';
    }

    // Helper: generate E-Ticket PDF
    public function generateETicket()
    {
        $data = [
            'registration' => $this,
            'user' => $this->user,
            'event' => $this->ticketCategory->event,
            'category' => $this->ticketCategory,
        ];

        $pdf = Pdf::loadView('etickets.show', $data);
        $path = "etickets/registration_{$this->id}.pdf";
        Storage::put($path, $pdf->output());
        
        $this->update([
            'eticket_path' => $path,
        ]);

        return $path;
    }

    // Helper: generate nomor registrasi unik
    public function getRegistrationNumber()
    {
        return 'REG-' . str_pad($this->id, 6, '0', STR_PAD_LEFT);
    }
}