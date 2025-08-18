<?php

namespace App\Services;

use App\Models\Address;
use App\Errors\AddressException;

class AddressService
{
    private Address $address;

    public function __construct(Address $address)
    {
        $this->address = $address;
    }
    public function createAddress(array $data): Address
    {
        $address = $this->address->create($data);
        if (!$address) {
            throw new AddressException('Address could not be created', 500);
        }
        return $address;
    }

    public function updateAddress(int $id, array $data): Address
    {
        $address = $this->address->find($id);
        if(!$address) {
            throw new AddressException('Address not found.', 404);
        }

        $address->fill($data);
        $address->save();
        return $address;
    }

    public function deleteAddress(int $id)
    {
        // Business logic for deleting an address can be added here
    }

    public function getAddress(int $id)
    {
        // Business logic for retrieving an address can be added here
    }

    public function getAllAddresses()
    {
        // Business logic for retrieving all addresses can be added here
    }
}