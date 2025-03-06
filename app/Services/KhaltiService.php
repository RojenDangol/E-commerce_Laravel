<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class KhaltiService
{
    private $baseUrl;
    private $secretKey;

    public function __construct()
    {
        $this->baseUrl = config('app.khalti_base_url', 'https://dev.khalti.com/api/v2/');
        $this->secretKey = config('app.khalti_secret_key');
    }

    /**
     * Verify the payment with Khalti API
     */
    public function verifyPayment($token, $amount)
    {
        $response = Http::withHeaders([
            'Authorization' => 'Key ' . $this->secretKey
        ])->post($this->baseUrl . 'payment/verify/', [
            'token' => $token,
            'amount' => $amount
        ]);

        $data = $response->json();

        if ($response->successful() && isset($data['idx'])) {
            return ['success' => true, 'data' => $data];
        }

        return ['success' => false, 'error' => $data];
    }

    /**
     * Log payment response for debugging
     */
    public function logPaymentResponse($response)
    {
        Log::info('Khalti Payment Response:', $response);
    }
}
