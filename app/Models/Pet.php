<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Pet extends Model
{
    use HasFactory , SoftDeletes;
    protected $fillable = ['pet_type'];

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }
}
