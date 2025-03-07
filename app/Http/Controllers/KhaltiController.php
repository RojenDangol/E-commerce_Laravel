<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Services\KhaltiService;

class KhaltiController extends Controller
{
    protected $khalti;

    public function __construct(KhaltiService $khalti)
    {
        $this->khalti = $khalti;
    }

    public function index(){
        return view('payment');
    }

    public function checkout(Product $product)
    {
        return $this->khalti->pay(
            1000, 
            route('khalti.verification', ['product' => $product->slug]), 
            $product->id, 
            $product->name
        );
    }

    public function verification(Request $request, Product $product)
    {
        $transaction_code = $request->transaction_code;

        $inquiry = $this->khalti->inquiry($transaction_code, $request->all());

        return $this->khalti->isSuccess($inquiry) 
            ? response()->json(['message' => 'Payment successful', 'data' => $inquiry])
            : response()->json(['message' => 'Payment failed'], 400);
    }
}
