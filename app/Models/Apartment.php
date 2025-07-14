<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\ApartmentImages;
use App\Models\ApartmentInfo;

class Apartment extends Model
{
    protected $table = 'apartments';

    protected $fillable = [
        'name',
        'price',
        'capacity',
    ];


    public function apartmentImages()
    {
        return $this->hasMany(ApartmentImages::class, 'apartment_id');
    }

    public function apartmentInfos()
    {
        return $this->hasMany(ApartmentInfo::class, 'apartment_id');
    }
}
