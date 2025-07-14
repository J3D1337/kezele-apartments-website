<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Hbeach;


class Beach extends Model
{
    protected $table = 'beaches';

    protected $fillable = [
        'name',
    ];


    public function beachImages()
    {
        return $this->hasMany(Hbeach::class, 'beach_id');
    }
}
