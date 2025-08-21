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

        $ageRanges = $this->client
                        ->select(DB::raw("
                            CASE 
                                WHEN age BETWEEN 0 AND 10 THEN '0-10'
                                WHEN age BETWEEN 11 AND 20 THEN '11-20'
                                WHEN age BETWEEN 21 AND 30 THEN '21-30'
                                WHEN age BETWEEN 31 AND 40 THEN '31-40'
                                WHEN age BETWEEN 41 AND 50 THEN '41-50'
                                WHEN age BETWEEN 51 AND 60 THEN '51-60'
                                ELSE '60+' 
                            END as age_range"),
                            DB::raw('COUNT(*) as total')
                        )
                        ->groupBy('age_range')
                        ->orderBy('age_range')
                        ->get();


        return compact('city', 'state', 'ageRanges');
    }
}