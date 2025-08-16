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
        'age',
        'address_id',
        'picture_id',
    ];

    public function address()
    {
        return $this->belongsTo(Address::class);
    }

    public function picture()
    {
        return $this->belongsTo(Picture::class);
    }

    public static function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:clients,email',
            'phone' => 'nullable|string|max:20',
            'age' => 'nullable|integer|min:0',
        ];
    }
}
