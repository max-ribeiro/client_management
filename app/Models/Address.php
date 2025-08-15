<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    protected $fillable = [
        'street',
        'neighborhood',
        'number',
        'state',
        'city',
        'active'
    ];

    public function clients()
    {
        return $this->hasMany(Client::class);
    }
}
