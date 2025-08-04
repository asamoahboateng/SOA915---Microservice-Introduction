<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Exception;

class ServiceApi
{
    public static function getServices()
    {
//        return [
//            [
//                'id' => 1,
//                'name' => 'Service One',
//                'description' => 'Description for Service One',
//                'duration' => 60, // in minutes
//                'price' => 100.00,
//                'is_active' => true,
//            ],
//            [
//                'id' => 2,
//                'name' => 'Service Two',
//                'description' => 'Description for Service Two',
//                'duration' => 30, // in minutes
//                'price' => 50.00,
//                'is_active' => true,
//            ]
//        ];

        try {
            $url = rtrim(env('SERVICE_API_ENDPOINT'), '/') . '/api/services';
            $response = Http::timeout(10)->get($url);

            if ($response->successful()) {
                return $response->json();
            }

            Log::warning('Service API call failed', [
                'url' => $url,
                'status' => $response->status(),
                'body' => $response->body(),
            ]);
        } catch (Exception $e) {
            Log::error('Service API exception', [
                'message' => $e->getMessage(),
            ]);
        }

        return [
            'error' => true,
            'message' => 'Unable to fetch services at this time.',
        ];
    }
}
