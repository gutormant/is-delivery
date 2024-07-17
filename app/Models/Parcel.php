<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Parcel extends Model
{
    protected $fillable = [
        'user_id',
        'width',
        'height',
        'depth',
        'weight',
        'service',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
