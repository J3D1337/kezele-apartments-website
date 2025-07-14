<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ApartmentImages extends Model
{
    protected $table = 'apartment_images';

    protected $fillable = [
        'image',
        'apartment_id',
    ];

}
