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

    public static function rules($id = null)
    {
        $isUpdate = !is_null($id);

        return [
            // Client
            'name'  => ($isUpdate ? 'sometimes' : 'required') . '|string|max:255',
            'email' => ($isUpdate ? 'sometimes' : 'required') . '|email|max:255|unique:clients,email' . ($id ? ',' . $id : ''),
            'phone' => 'sometimes|nullable|string|max:20',
            'age'   => 'sometimes|nullable|integer|min:0',

            // Address
            'address' => $isUpdate ? 'sometimes|array' : 'required|array',
            'address.street' => ($isUpdate ? 'sometimes' : 'required') . '|string|max:255',
            'address.city'   => ($isUpdate ? 'sometimes' : 'required') . '|string|max:255',
            'address.state'  => ($isUpdate ? 'sometimes' : 'required') . '|string|max:255',
            'address.neighborhood' => 'sometimes|nullable|string|max:255',
            'address.number' => ($isUpdate ? 'sometimes' : 'required') . '|string|max:20',

            // Picture (opcional em ambos, mas se vier precisa ser válido)
            'picture' => 'sometimes|nullable|array',
            'picture.content' => [
                'required_with:picture',  // só valida se picture vier
                'string',
                'regex:/^[A-Za-z0-9+\/=]+$/', // valida base64
            ],
        ];
    }
}
