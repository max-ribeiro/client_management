<?php

namespace App\Services;

use App\Models\Client;
use Illuminate\Support\Facades\DB;

class ReportService {
    private Client $client;
    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function getChartData() {
        $city = $this->client
            ->join('addresses', 'clients.address_id', '=', 'addresses.id')
            ->select('addresses.city', DB::raw('COUNT(*) AS total'))
            ->whereNotNull('addresses.city')
            ->groupBy('addresses.city')
            ->orderByDesc('total')
            ->get();

        $state = $this->client
            ->join('addresses', 'clients.address_id', '=', 'addresses.id')
            ->select('addresses.state', DB::raw('COUNT(*) AS total'))
            ->whereNotNull('addresses.state')
            ->groupBy('addresses.state')
            ->orderByDesc('total')
            ->get();

        return compact('city', 'state');
    }
}