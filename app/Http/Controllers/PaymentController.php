<?php 
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class PaymentController extends Controller
{
    public function index()
    {
        return view('payment'); // Return a view with the Khalti payment form
    }

    public function verifyPayment(Request $request)
    {
        $url = "https://a.khalti.com/api/v2/epayment/initiate/";
        $data = [
            'token' => $request->input('token'),
            'amount' => $request->input('amount'),
        ];

        $response = Http::withHeaders([
            'Authorization' => 'Key ' . env('KHALTI_SECRET_KEY'),
        ])->post($url, $data);

        if ($response->successful()) {
            return response()->json(['success' => true, 'message' => 'Payment verified successfully!']);
        } else {
            return response()->json(['success' => false, 'message' => 'Payment verification failed!']);
        }
    }
}
