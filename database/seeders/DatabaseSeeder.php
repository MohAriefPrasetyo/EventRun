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
        // USERS
        $admin = User::firstOrCreate(['email' => 'admin@eventrun.com'], [
            'name'     => 'Admin',
            'password' => Hash::make('password'),
            'role'     => 'admin',
        ]);

        $volunteer = User::firstOrCreate(['email' => 'volunteer@eventrun.com'], [
            'name'     => 'Budi Santoso',
            'password' => Hash::make('password'),
            'role'     => 'volunteer',
        ]);

        $participant1 = User::firstOrCreate(['email' => 'andi@eventrun.com'], [
            'name'     => 'Andi Pratama',
            'password' => Hash::make('password'),
            'role'     => 'participant',
        ]);

        $participant2 = User::firstOrCreate(['email' => 'siti@eventrun.com'], [
            'name'     => 'Siti Rahayu',
            'password' => Hash::make('password'),
            'role'     => 'participant',
        ]);

        $participant3 = User::firstOrCreate(['email' => 'doni@eventrun.com'], [
            'name'     => 'Doni Kurniawan',
            'password' => Hash::make('password'),
            'role'     => 'participant',
        ]);

        // EVENTS
        $event1 = Event::firstOrCreate(['name' => 'Jakarta Marathon 2026'], [
            'date'        => '2026-07-20',
            'location'    => 'Monas, Jakarta Pusat',
            'description' => 'Event lari tahunan terbesar di Jakarta. Tersedia kategori 5K, 10K, dan Half Marathon untuk semua kalangan.',
        ]);

        $event2 = Event::firstOrCreate(['name' => 'Bandung Fun Run 2026'], [
            'date'        => '2026-08-10',
            'location'    => 'Gedung Sate, Bandung',
            'description' => 'Fun run seru di kota kembang dengan pemandangan indah. Cocok untuk keluarga dan komunitas lari.',
        ]);

        $event3 = Event::firstOrCreate(['name' => 'Bali Beach Run 2026'], [
            'date'        => '2026-09-05',
            'location'    => 'Pantai Kuta, Bali',
            'description' => 'Lari di tepi pantai Bali yang eksotis. Nikmati sunrise sambil berlari bersama ribuan peserta.',
        ]);

        // TICKET CATEGORIES
        $cat_jkt_5k = TicketCategory::firstOrCreate(['event_id' => $event1->id, 'category_name' => '5K'], [
            'price' => 150000, 'quota' => 500,
        ]);

        $cat_jkt_10k = TicketCategory::firstOrCreate(['event_id' => $event1->id, 'category_name' => '10K'], [
            'price' => 250000, 'quota' => 300,
        ]);

        $cat_jkt_half = TicketCategory::firstOrCreate(['event_id' => $event1->id, 'category_name' => 'Half Marathon'], [
            'price' => 400000, 'quota' => 150,
        ]);

        $cat_bdg_5k = TicketCategory::firstOrCreate(['event_id' => $event2->id, 'category_name' => '5K'], [
            'price' => 100000, 'quota' => 400,
        ]);

        $cat_bdg_10k = TicketCategory::firstOrCreate(['event_id' => $event2->id, 'category_name' => '10K'], [
            'price' => 175000, 'quota' => 200,
        ]);

        $cat_bali_5k = TicketCategory::firstOrCreate(['event_id' => $event3->id, 'category_name' => '5K'], [
            'price' => 200000, 'quota' => 300,
        ]);

        $cat_bali_10k = TicketCategory::firstOrCreate(['event_id' => $event3->id, 'category_name' => '10K'], [
            'price' => 350000, 'quota' => 200,
        ]);

        // REGISTRATIONS
        $reg1 = Registration::create([
            'user_id'            => $participant1->id,
            'ticket_category_id' => $cat_jkt_10k->id,
            'status'             => 'verified',
            'verified_at'        => now()->subDays(2),
        ]);

        $reg2 = Registration::create([
            'user_id'            => $participant1->id,
            'ticket_category_id' => $cat_bdg_5k->id,
            'status'             => 'claimed',
            'verified_at'        => now()->subDays(5),
        ]);

        $reg3 = Registration::create([
            'user_id'            => $participant2->id,
            'ticket_category_id' => $cat_jkt_5k->id,
            'status'             => 'waiting_verification',
        ]);

        $reg4 = Registration::create([
            'user_id'            => $participant2->id,
            'ticket_category_id' => $cat_bali_10k->id,
            'status'             => 'pending',
        ]);

        $reg5 = Registration::create([
            'user_id'            => $participant3->id,
            'ticket_category_id' => $cat_jkt_half->id,
            'status'             => 'verified',
            'verified_at'        => now()->subDay(),
        ]);

        $reg6 = Registration::create([
            'user_id'            => $participant3->id,
            'ticket_category_id' => $cat_bali_5k->id,
            'status'             => 'waiting_verification',
        ]);

        // RACE PACKS
        RacePack::create([
            'registration_id' => $reg2->id,
            'volunteer_id'    => $volunteer->id,
            'claimed_at'      => now()->subDays(3),
        ]);
    }
}
