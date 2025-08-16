<?php

namespace App\Services;

use App\Models\Client;
use App\Services\AddressService;
use App\Services\PictureService;
use App\Errors\ClientException;

class ClientService
{
    private Client $client;
    private AddressService $addressService;
    private PictureService $pictureService;

    public function __construct(Client $client, AddressService $addressService, PictureService $pictureService)
    {
        $this->client = $client;
        $this->addressService = $addressService;
        $this->pictureService = $pictureService;
    }

    /**
     * Create a new client
     *
     * @param array $data
     * @return Client
     */
    public function createClient(array $data): Client
    {
        $address = $this->addressService->createAddress($data['address']);
        $picture = $this->pictureService->createPicture($data['picture']);

        $clientData = array_merge($data, ['address_id' => $address->id, 'picture_id' => $picture->id]);
        unset($clientData['address'], $clientData['picture']);

        $client = $this->client->create($clientData);
        if (!$client) {
            throw new ClientException('Client could not be created', 500);
        }
        return $client;
    }

    public function updateClient(int $id, array $data)
    {
        // Business logic for updating a client can be added here
    }

    public function deleteClient(int $id)
    {
        // Business logic for deleting a client can be added here
    }

    public function getClient(int $id)
    {
        // Business logic for retrieving a client can be added here
    }

    public function getAllClients()
    {
        // Business logic for retrieving all clients can be added here
    }
}