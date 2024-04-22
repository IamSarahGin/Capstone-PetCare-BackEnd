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
            $table->string('time');
            $table->string('pet_name');
            $table->string('breed');
            $table->integer('age');
            $table->string('color');
            $table->text('symptoms');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('user_email');
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->foreignId('pet_id')->constrained('pets')->onDelete('cascade');
            $table->string('pet_type')->nullable();
            $table->string('service_type')->nullable();
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
