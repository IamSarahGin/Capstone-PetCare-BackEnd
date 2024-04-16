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
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->time('time');
            $table->string('pet_name');
            $table->string('breed'); // Added breed field
            $table->integer('age'); // Added age field
            $table->string('color'); // Added color field
            $table->text('symptoms'); // Added symptoms field
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('user_email'); // Added user_email field
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};