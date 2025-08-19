<?php

namespace App\Services;

use App\Models\Client;
use App\Services\AddressService;
use App\Services\PictureService;
use App\Errors\ClientException;
use App\Errors\AddressException;
use App\Errors\PictureException;
use Illuminate\Database\Eloquent\Collection;

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
     * @param array $data dados do cliente
     * @throws ClientException
     * @throws AddressException
     * @throws PictureException
     * @return Client
     */
    public function createClient(array $data): Client
    {
        $address = $this->addressService->createAddress($data['address']);
        $addressId = $address->id;
        $pictureId = null;

        if(!empty($data['picture'])) {
            $picture = $this->pictureService->createPicture($data['picture']);
            $pictureId = $picture->id;
        }

        $clientData = array_merge($data, ['address_id' => $addressId, 'picture_id' => $pictureId]);
        unset($clientData['address'], $clientData['picture']);

        $client = $this->client->create($clientData);
        if (!$client) {
            throw new ClientException('Client could not be created', 500);
        }
        return $client->fresh(['address', 'picture']);;
    }

    /**
     * Update an existing client
     *
     * @param int $id
     * @param array $data
     * @throws ClientException
     * @return Client
     */
    public function updateClient(int $id, array $data): Client
    {
        $client = $this->client->with('address', 'picture')->find($id);

        if (!$client) {
            throw new ClientException('Client not found', 404);
        }

        if (!empty($data['address'])) {
            if ($client->address_id) {
                $address = $this->addressService->updateAddress($client->address->id, $data['address']);
                $addressId = $client->address->id;
            } else {
                $address = $this->addressService->createAddress($data['address']);
                $addressId = $address->id;
            }
            $data['address_id'] = $addressId;
        }

        if (!empty($data['picture'])) {
            if ($client->picture_id) {
                $this->pictureService->updatePicture($client->picture->id, $data['picture']);
                $pictureId = $client->picture->id;
            } else {
                $picture = $this->pictureService->createPicture($data['picture']);
                $pictureId = $picture->id;
            }
            $data['picture_id'] = $pictureId;
        }

        // Remove nested objects before filling client
        unset($data['address'], $data['picture']);

        $client->fill($data);
        $client->save();

        return $client->fresh(['address', 'picture']);
    }

    /**
     * Delete a client by ID
     *
     * @param int $id
     * @throws ClientException
     * @return bool
     */
    public function deleteClient(int $id): bool
    {
        $client = $this->client->find($id);
        if (!$client) {
            throw new ClientException('Client not found', 404);
        }
        return $client->delete();
    }

    /**
     * Retrieve a client by ID or all clients if no ID is provided
     *
     * @param array $ids
     * @return Collection
     */
    public function getClients(array $ids = [], array $queryParams = []): Collection
    {
        $client = $this->client->with('address', 'picture');
        if (!empty($ids)) {
            $client = $client->whereIn('id', $ids);
        }
        return $client->get();
    }
}