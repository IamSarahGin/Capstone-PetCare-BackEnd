<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pet extends Model
{
    use HasFactory;
    protected $fillable = ['pet_type'];

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }
}
