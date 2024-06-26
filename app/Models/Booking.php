<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;
    protected $fillable = [
        'date', 
        'time', 
        'pet_name', 
        'breed', 
        'age', 
        'color', 
        'symptoms', 
        'user_id',
        'user_email',
        'status',
        'pet_id', 
        'pet_type', 
        "service_type",

    ];

    // Define the relationship with the User model
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}