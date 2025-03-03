<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Khalti Test Payment</title>
    <script src="https://khalti.s3.ap-south-1.amazonaws.com/KPG/dist/2020.12.17.0.0.0/khalti-checkout.iffe.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
</head>
<body>
    <h2>Test Khalti Payment</h2>
    <button id="payment-button">Pay with Khalti</button>

    <script>

        var khaltiPublicKey = "{{ config('app.khalti_public_key') }}";
        console.log(khaltiPublicKey);
        var config = {
            "publicKey": khaltiPublicKey,
            "productIdentity": "test_product_123",
            "productName": "Test Product",
            "productUrl": "https://example.com/product",
            "paymentPreference": ["KHALTI","EBANKING","MOBILE_BANKING","CONNECT_IPS","SCT"],
            "eventHandler": {
                onSuccess (payload) {
                    console.log("Payment successful!", payload);

                    $.ajax({
                        url: "/verify-payment",
                        type: "POST",
                        data: {
                            token: payload.token,
                            amount: payload.amount,
                            _token: "{{ csrf_token() }}"
                        },
                        success: function (response) {
                            if (response.state === "Completed") {
                                alert("Payment verified successfully!");
                            } else {
                                alert("Payment verification failed!");
                            }
                        },
                        error: function () {
                            alert("Error verifying payment.");
                        }
                    });
                },
                onError (error) {
                    console.log("Payment error:", error);
                },
                onClose () {
                    console.log('Payment widget closed');
                }
            }
        };

        var checkout = new KhaltiCheckout(config);
        var btn = document.getElementById("payment-button");
        btn.onclick = function () {
            checkout.show({amount: 1000}); // Amount in paisa (10 NPR)
        }
    </script>
</body>
</html>
