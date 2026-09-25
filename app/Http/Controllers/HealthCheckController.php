<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Throwable;

class HealthCheckController extends Controller
{
    public function __invoke(): JsonResponse
    {
        $dbStatus = 'ok';

        try {
            DB::connection()->getPdo();
        } catch (Throwable) {
            $dbStatus = 'unavailable';
        }

        $isHealthy = $dbStatus === 'ok';

        return response()->json([
            'status' => $isHealthy ? 'healthy' : 'degraded',
            'application' => 'Solmir',
            'database' => $dbStatus,
            'timestamp' => now()->toIso8601String(),
        ], $isHealthy ? 200 : 503);
    }
}
