<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Khalti Payment</title>
    
    {{-- Load Khalti Payment Script --}}
    <script src="https://khalti.s3.ap-south-1.amazonaws.com/KPG/dist/2020.12.17.0.0.0/khalti-checkout.iffe.js"></script>
    
    {{-- jQuery for AJAX --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
</head>
<body>

    <h2>Pay with Khalti</h2>
    <button id="payment-button">Pay with Khalti</button>

    <script>
        var khaltiPublicKey = "{{ $khaltiPublicKey }}";  // Get public key from Laravel
    
        if (!khaltiPublicKey || khaltiPublicKey.includes("KHALTI_PUBLIC_KEY")) {
            console.error("Invalid or missing Khalti Public Key");
        }
    
        // Configure Khalti Checkout
        var config = {
            "publicKey": khaltiPublicKey,
            "productIdentity": "1234567890",
            "productName": "Dragon",
            "productUrl": "http://gameofthrones.wikia.com/wiki/Dragons",
            "paymentPreference": ["KHALTI", "EBANKING", "MOBILE_BANKING", "CONNECT_IPS", "SCT"],
            "eventHandler": {
                onSuccess(payload) {
                    $.ajax({
                        type: 'POST',
                        url: "{{ route('payment.verify') }}",
                        data: {
                            token: payload.token,
                            amount: payload.amount,
                            "_token": "{{ csrf_token() }}"
                        },
                        success: function (response) {
                            $.ajax({
                                type: 'POST',
                                url: "{{ route('payment.store') }}",
                                data: {
                                    response: response,
                                    "_token": "{{ csrf_token() }}"
                                },
                                success: function () {
                                    alert("Payment Successful!");
                                }
                            });
                        }
                    });
                },
                onError(error) { console.error("Khalti Payment Error:", error); },
                onClose() { console.log("Khalti Payment Widget Closed"); }
            }
        };
    
        var checkout = new KhaltiCheckout(config);
        document.getElementById("payment-button").onclick = function () {
            checkout.show({ amount: 1000 }); // Rs. 10 (1000 paisa)
        }
    </script>
</body>
</html>
