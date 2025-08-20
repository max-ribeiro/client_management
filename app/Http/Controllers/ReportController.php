<?php

namespace App\Http\Controllers;

use App\Services\ReportService;
use Illuminate\Http\JsonResponse;

class ReportController extends Controller
{
    private ReportService $service;
    public function __construct(ReportService $service)
    {
        $this->service = $service;       
    }
    public function getChartData(): JsonResponse {
        try {
            $chartData = $this->service->getChartData();
            return response()->json($chartData, 200);
        } catch(\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }
}
