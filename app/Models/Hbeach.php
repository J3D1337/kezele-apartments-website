<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use app\Models\Beach;

class Hbeach extends Model
{
    protected $fillable = ['image', 'beach_id'];

    public function beach()
    {
        return $this->belongsTo(Beach::class, 'beach_id');
    }
}
