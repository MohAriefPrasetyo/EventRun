<?php

namespace Database\Seeders;

use App\Models\Event;
use App\Models\RacePack;
use App\Models\Registration;
use App\Models\TicketCategory;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        // -------------------------------------------------------
        // USERS
        // -------------------------------------------------------
        $admin = User::create([
            'name'     => 'Admin',
            'email'    => 'admin@eventrun.com',
            'password' => Hash::make('password'),
            'role'     => 'admin',
        ]);

        $volunteer = User::create([
            'name'     => 'Budi Santoso',
            'email'    => 'volunteer@eventrun.com',
            'password' => Hash::make('password'),
            'role'     => 'volunteer',
        ]);

        $participant1 = User::create([
            'name'     => 'Andi Pratama',
            'email'    => 'andi@eventrun.com',
            'password' => Hash::make('password'),
            'role'     => 'participant',
        ]);

        $participant2 = User::create([
            'name'     => 'Siti Rahayu',
            'email'    => 'siti@eventrun.com',
            'password' => Hash::make('password'),
            'role'     => 'participant',
        ]);

        $participant3 = User::create([
            'name'     => 'Doni Kurniawan',
            'email'    => 'doni@eventrun.com',
            'password' => Hash::make('password'),
            'role'     => 'participant',
        ]);

        // -------------------------------------------------------
        // EVENTS
        // -------------------------------------------------------
        $event1 = Event::create([
            'name'        => 'Jakarta Marathon 2026',
            'date'        => '2026-07-20',
            'location'    => 'Monas, Jakarta Pusat',
            'description' => 'Event lari tahunan terbesar di Jakarta. Tersedia kategori 5K, 10K, dan Half Marathon untuk semua kalangan.',
        ]);

        $event2 = Event::create([
            'name'        => 'Bandung Fun Run 2026',
            'date'        => '2026-08-10',
            'location'    => 'Gedung Sate, Bandung',
            'description' => 'Fun run seru di kota kembang dengan pemandangan indah. Cocok untuk keluarga dan komunitas lari.',
        ]);

        $event3 = Event::create([
            'name'        => 'Bali Beach Run 2026',
            'date'        => '2026-09-05',
            'location'    => 'Pantai Kuta, Bali',
            'description' => 'Lari di tepi pantai Bali yang eksotis. Nikmati sunrise sambil berlari bersama ribuan peserta.',
        ]);

        // -------------------------------------------------------
        // TICKET CATEGORIES
        // -------------------------------------------------------

        // Jakarta Marathon
        $cat_jkt_5k = TicketCategory::create([
            'event_id'      => $event1->id,
            'category_name' => '5K',
            'price'         => 150000,
            'quota'         => 500,
        ]);

        $cat_jkt_10k = TicketCategory::create([
            'event_id'      => $event1->id,
            'category_name' => '10K',
            'price'         => 250000,
            'quota'         => 300,
        ]);

        $cat_jkt_half = TicketCategory::create([
            'event_id'      => $event1->id,
            'category_name' => 'Half Marathon',
            'price'         => 400000,
            'quota'         => 150,
        ]);

        // Bandung Fun Run
        $cat_bdg_5k = TicketCategory::create([
            'event_id'      => $event2->id,
            'category_name' => '5K',
            'price'         => 100000,
            'quota'         => 400,
        ]);

        $cat_bdg_10k = TicketCategory::create([
            'event_id'      => $event2->id,
            'category_name' => '10K',
            'price'         => 175000,
            'quota'         => 200,
        ]);

        // Bali Beach Run
        $cat_bali_5k = TicketCategory::create([
            'event_id'      => $event3->id,
            'category_name' => '5K',
            'price'         => 200000,
            'quota'         => 300,
        ]);

        $cat_bali_10k = TicketCategory::create([
            'event_id'      => $event3->id,
            'category_name' => '10K',
            'price'         => 350000,
            'quota'         => 200,
        ]);

        // -------------------------------------------------------
        // REGISTRATIONS
        // -------------------------------------------------------

        // Andi - sudah verified (siap ambil race pack)
        $reg1 = Registration::create([
            'user_id'             => $participant1->id,
            'ticket_category_id'  => $cat_jkt_10k->id,
            'payment_proof'       => null,
            'status'              => 'verified',
            'verified_at'         => now()->subDays(2),
        ]);

        // Andi - sudah claimed
        $reg2 = Registration::create([
            'user_id'             => $participant1->id,
            'ticket_category_id'  => $cat_bdg_5k->id,
            'payment_proof'       => null,
            'status'              => 'claimed',
            'verified_at'         => now()->subDays(5),
        ]);

        // Siti - menunggu verifikasi
        $reg3 = Registration::create([
            'user_id'             => $participant2->id,
            'ticket_category_id'  => $cat_jkt_5k->id,
            'payment_proof'       => null,
            'status'              => 'waiting_verification',
            'verified_at'         => null,
        ]);

        // Siti - pending (belum upload bukti)
        $reg4 = Registration::create([
            'user_id'             => $participant2->id,
            'ticket_category_id'  => $cat_bali_10k->id,
            'payment_proof'       => null,
            'status'              => 'pending',
            'verified_at'         => null,
        ]);

        // Doni - verified
        $reg5 = Registration::create([
            'user_id'             => $participant3->id,
            'ticket_category_id'  => $cat_jkt_half->id,
            'payment_proof'       => null,
            'status'              => 'verified',
            'verified_at'         => now()->subDay(),
        ]);

        // Doni - waiting verification
        $reg6 = Registration::create([
            'user_id'             => $participant3->id,
            'ticket_category_id'  => $cat_bali_5k->id,
            'payment_proof'       => null,
            'status'              => 'waiting_verification',
            'verified_at'         => null,
        ]);

        // -------------------------------------------------------
        // RACE PACKS (hanya untuk status 'claimed')
        // -------------------------------------------------------
        RacePack::create([
            'registration_id' => $reg2->id,
            'volunteer_id'    => $volunteer->id,
            'claimed_at'      => now()->subDays(3),
        ]);
    }
}
