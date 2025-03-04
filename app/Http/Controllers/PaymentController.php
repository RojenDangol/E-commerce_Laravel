<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Config;

class PaymentController extends Controller
{
    public function index()
    {
        return view('payment',[
            'khaltiPublicKey' => Config::get('app.khalti_public_key')
        ]);
    }

    public function verifyPayment(Request $request)
    {
        $token = $request->token;
        $amount = $request->amount;

        $response = Http::withHeaders([
            'Authorization' => 'Key ' . config('app.khalti_secret_key')
        ])->post('https://khalti.com/api/v2/payment/verify/', [
            'token' => $token,
            'amount' => $amount
        ]);

        return response()->json($response->json());
    }

    public function storePayment(Request $request){
        \Log::info('Khalti Payment Response: ', $request->all());

        return response()->json(['message' => 'Payment recorded successfully!']);
    }
}
