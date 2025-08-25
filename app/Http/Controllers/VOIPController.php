<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Services\ClientService;
use App\Services\VOIPService;
use Illuminate\Http\JsonResponse;

class VOIPController extends Controller
{
    private VOIPService $voipService;
    private ClientService $clientService;

    public function __construct(VOIPService $voipService, ClientService $clientService)
    {
        $this->voipService = $voipService;
        $this->clientService = $clientService;
    }

    public function call(int $id): JsonResponse
    {
        $client = $this->clientService->getClient($id);
        if (!$client->phone) {
            return response()->json(['error' => 'Contato não possui telefone'], 400);
        }

        $phone = '55'.$client->phone;
        $callSID = $this->voipService->call($phone);

        return response()->json([
            'message' => 'Ligação iniciada com sucesso',
            'call_sid' => $callSID,
            'client'   => $client->only(['id', 'name', 'phone'])
        ]);
    }
}