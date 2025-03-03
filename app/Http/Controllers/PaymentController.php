<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class PaymentController extends Controller
{
    public function index()
    {
        return view('payment');
    }

    public function verifyPayment(Request $request)
    {
        $url = "https://a.khalti.com/api/v2/payment/verify/";

        $response = Http::withHeaders([
            'Authorization' => 'Key ' . config('app.khalti_secret_key'),
        ])->post($url, [
            'token' => $request->input('token'),
            'amount' => $request->input('amount'),
        ]);

        if ($response->successful()) {
            return response()->json([
                'success' => true,
                'message' => 'Payment verified successfully!',
                'data' => $response->json()
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Payment verification failed!',
                'error' => $response->json()
            ]);
        }
    }
}
