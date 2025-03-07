<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Khalti Payment</title>
</head>
<body>
    <h2>Proceed with Khalti Payment</h2>
    @php
        $product = \App\Models\Product::where('slug', 'gucci-bomber-jacket')->first();
    @endphp
    <form action="{{ route('khalti.checkout', ['product' => $product->slug]) }}" method="GET">
        @csrf
        <button type="submit">Pay with Khalti</button>
    </form>
</body>
</html>
