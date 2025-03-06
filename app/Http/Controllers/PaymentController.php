<?php

namespace App\Http\Controllers;

use App\Services\KhaltiService;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    private $khaltiService;

    public function __construct(KhaltiService $khaltiService)
    {
        $this->khaltiService = $khaltiService;
    }

    /**
     * Show the payment page.
     */
    public function index()
    {
        return view('payment', [
            'khaltiPublicKey' => config('app.khalti_public_key')
        ]);
    }

    /**
     * Verify Khalti payment.
     */
    public function verifyPayment(Request $request)
    {
        $request->validate([
            'token' => 'required|string',
            'amount' => 'required|integer|min:1000',
        ]);

        $result = $this->khaltiService->verifyPayment($request->token, $request->amount);

        if ($result['success']) {
            return response()->json(['success' => true, 'data' => $result['data']]);
        }

        return response()->json(['success' => false, 'error' => $result['error']], 400);
    }

    /**
     * Store payment details.
     */
    public function storePayment(Request $request)
    {
        $this->khaltiService->logPaymentResponse($request->all());

        return response()->json(['message' => 'Payment recorded successfully!']);
    }
}
