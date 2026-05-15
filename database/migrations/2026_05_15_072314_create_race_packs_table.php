<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('race_packs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('registration_id')->unique()->constrained()->onDelete('cascade');
            $table->foreignId('volunteer_id')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamp('claimed_at')->useCurrent();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('race_packs');
    }
};