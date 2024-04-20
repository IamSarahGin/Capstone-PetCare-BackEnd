<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TimeSlot extends Model
{
    use HasFactory;
    protected $fillable = ['date', 'start_time', 'end_time', 'availability','user_id',
        'user_email',];
    // Inside your User model

}
