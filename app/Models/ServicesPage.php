<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServicesPage extends Model
{
    use HasFactory;
    protected $fillable = [
        'image1',
        'image2',
        'image3',
        'title1',
        'title2',
        'title3',
        'title4',
    ];
}
