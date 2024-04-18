<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('time_slots', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->time('startTime');
            $table->time('endTime');
            $table->enum('availability', ['available', 'booked'])->default('available');
            $table->unsignedBigInteger('user_id')->nullable()->after('availability');
            $table->string('user_email')->nullable()->after('user_id');
            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('time_slots');
    }
};
