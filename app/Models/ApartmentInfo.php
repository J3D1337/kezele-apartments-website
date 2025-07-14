<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class ApartmentInfo extends Model
{
    protected $table = 'apartment_infos';

    protected $fillable = [
        'content',
        'apartment_id',
        'locale',
    ];

}
