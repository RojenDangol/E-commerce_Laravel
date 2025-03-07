<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use App\Interfaces\PaymentGatewayInterface;
use Exception;

class KhaltiService implements PaymentGatewayInterface
{
    private $amount;
    private $base_url;
    private $purchase_order_id;
    private $purchase_order_name;
    private $inquiry_response;
    private $customer_name;
    private $customer_phone;
    private $customer_email;

    public function __construct()
    {
        $this->base_url = env('APP_DEBUG') ? 'https://a.khalti.com/api/v2/' : 'https://khalti.com/api/v2/';
    }

    public function byCustomer($name, $email, $phone)
    {
        $this->customer_name = $name;
        $this->customer_email = $email;
        $this->customer_phone = $phone;
        return $this;
    }

    public function pay(float $amount, $return_url, $purchase_order_id, $purchase_order_name)
    {
        $this->purchase_order_id = $purchase_order_id;
        $this->purchase_order_name = $purchase_order_name;
        return $this->initiate($amount, $return_url);
    }

    public function initiate(float $amount, $return_url, ?array $arguments = null)
    {
        $this->amount = env('APP_DEBUG') ? 1000 : ($amount * 100);
        $process_url = $this->base_url . 'epayment/initiate/';

        $data = [
            "return_url" => $return_url,
            "website_url" => url('/'),
            "amount" =>  $this->amount,
            "purchase_order_id" => $this->purchase_order_id,
            "purchase_order_name" => $this->purchase_order_name,
            "customer_info" => [
                "name" => $this->customer_name,
                "email" => $this->customer_email,
                "phone" => $this->customer_phone
            ]
        ];

        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
            'Authorization' => 'Key ' . env('KHALTI_SECRET_KEY'),
        ])->post($process_url, $data);

        if ($response->ok()) {
            $body = json_decode($response->body());
            return redirect()->to($body->payment_url);
        } else {
            throw new Exception('Khalti transaction failed');
        }
    }

    public function isSuccess(array $inquiry, ?array $arguments = null): bool
    {
        return ($inquiry['status'] ?? null) == 'Completed';
    }

    public function requestedAmount(array $inquiry, ?array $arguments = null): float
    {
        return $inquiry['total_amount'];
    }

    public function inquiry($transaction_id, ?array $arguments = null): array
    {
        $process_url = $this->base_url . 'epayment/lookup/';
        $payload = ['pidx' => $transaction_id];

        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
            'Authorization' => 'Key ' . env('KHALTI_SECRET_KEY'),
        ])->post($process_url, $payload);

        $this->inquiry_response = json_decode($response->body(), true);
        return $this->inquiry_response;
    }
}
