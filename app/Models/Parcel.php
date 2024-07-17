<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Parcel extends Model
{
    use HasFactory;

    protected $fillable = [
//        'first_name',
//        'middle_name',
//        'last_name',
//        'phone',
//        'email',
//        'address',
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
