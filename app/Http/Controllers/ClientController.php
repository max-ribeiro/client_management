<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;
use Ramsey\Uuid\Type\Integer;

class ClientController extends Controller
{
    public Client $client;
    public function __construct(Client $client)
    {
        $this->client = $client;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $clients = $this->client->all();
        return response()->json($clients, 200);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {   
        try {
            $client = $this->client->create([
                'name' => $request->input('name'),
                'email' => $request->input('email'),
                'phone' => $request->input('phone'),
                'address_id' => $request->input('address'),
                'picture_id' => $request->input('picture'),
                'age' => $request->input('age'),
            ]);
    
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
    public function show(int $id)
    {
        $client = $this->client->find($id);
        if (!$client) {
            return response()->json(['message' => 'Client not found'], 404);
        }
        return response()->json($client, 200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Client $client)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Client $client)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Client $client)
    {
        //
    }
}
