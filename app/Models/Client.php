<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'address_id',
        'picture',
    ];

    // public function address()
    // {
    //     return $this->belongsTo(Address::class);
    // }

    // public function picture()
    // {
    //     return $this->belongsTo(Picture::class);
    // }
}
