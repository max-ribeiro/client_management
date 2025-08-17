<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;
use App\Services\ClientService;
use Illuminate\Database\Eloquent\Collection;

class ClientController extends Controller
{
    public Client $client;
    private ClientService $service;

    public function __construct(Client $client, ClientService $service)
    {
        $this->client = $client;
        $this->service = $service;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            $queryParams = $request->query() ?? [];

            $clients = $this->service->getClients([], $queryParams);
            return response()->json($clients, 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error listing clients'], 500);
        }
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {   
        try {
            $request->validate($this->client->rules());

            $params = $request->all();
            $client = $this->service->createClient($params);
            if (!$client) {
                return response()->json(['message' => 'Client could not be created'], 500);
            }
    
            return response()->json($client, 201);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error creating client.'], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, int $id)
    {
        try {
            $queryParams = $request->query() ?? [];

            $client = $this->service->getClients([$id], $queryParams);
            if ($client->isEmpty()) {
                return response()->json(['message' => 'Client not found'], 404);
            }
            
            return response()->json($client->first(), 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error retrieving client.'], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, int $id)
    {
        try {
            $params = $request->all();
            $client = $this->service->updateClient($id, $params);
            if (!$client) {
                return response()->json(['message' => 'Client not found'], 404);
            }

            return response()->json($client, 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error updating client.'], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        try {
            $clientDeleted = $this->service->deleteClient($id);
            if (!$clientDeleted) {
                return response()->json(['message' => 'Client not found'], 404);
            }

            return response()->json(['message' => 'Client deleted successfully'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error deleting client.'], 500);
        }
    }
}
