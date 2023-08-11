<!DOCTYPE html>
<html lang="en">

<head>
    @include('layout.head')
    <title>Accept a payment</title>
    <script src="https://js.stripe.com/v3/"></script>
    <link rel="stylesheet" href="/assets/css/checkout.css" />

</head>

<body>
    <div class="text-center pt-4">
        <!-- <h4 class="mb-3">Lists</h4> -->
    </div>
    <div class="container-md">
        <div class="row">
            <div class="col-md-5 mt-4">
                <div class="mb-4">
                    <a href="#" id="back-btn"><i class="fas fa-arrow-left-long"></i> DJ Nick Burrett</a>
                </div>
                <p>Stripe payment</p>
                <h1 class="price"></h1>
            </div>
            <div class="col-md-7 mt-4">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Pay with card</h5>
                    </div>
                    <div class="card-body">
                        <form action="/checkout-stripe" method="POST" id="payment-form">
                            <div id="checkout-form">
                                <div class="mb-4">
                                    <label class="form-label" for="email">Email</label>
                                    <input type="email" id="email" name="email" class="form-control" />
                                </div>
                                <div class="mb-4">
                                    <label class="form-label" for="name">Name</label>
                                    <input type="text" id="name" name="name" class="form-control" />
                                </div>
                                <div id="payment-element"></div>
                                <button id="payment-button" class="btn btn-primary mt-3">
                                    Pay Now
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        $('#back-btn').click(function(){
            window.history.back();
        });
        $("#email").val(localStorage.getItem('email'));
        $("#name").val(localStorage.getItem('name'));
        $(".price").html('£'+localStorage.getItem('price'));
        // Create a Stripe client.
        var stripe = Stripe('pk_test_51Nb0Q2ICth3bN2l6764pFq4TPeZK26lXyrDN5chzuw9N2b8mHpGCTpUh87LJlzoI5IP3u8JeBXiSnU6vn5BHyFo300RwVJGrXH');
        // Create an instance of Elements
        var elements = stripe.elements();
        
        var style = {
            base: {
                fontSize: '16px',
                fontFamily: 'Arial, sans-serif',
                minHeight: '46px',
            },
        };

        // Create an instance of the card Element
        var card = elements.create('card', { style: style });
        card.mount('#payment-element');

        // Handle form submission
        var form = document.getElementById('payment-form');
        form.addEventListener('submit', function(event) {
            event.preventDefault();
        
            stripe.createToken(card).then(function(result) {
                console.log(result.error, '______');
                if (result.error) {
                    // Inform the user if there was an error.
                    var errorElement = document.getElementById('card-errors');
                    errorElement.textContent = result.error.message;
                } else {
                    // Send the token to your server.
                    stripeTokenHandler(result.token);
                }
            });
        });
        
        // Submit the form with the token ID.
        function stripeTokenHandler(token) {
            // Insert the token ID into the form so it gets submitted to the server
            var form = document.getElementById('payment-form');
            var hiddenInput = document.createElement('input');
            hiddenInput.setAttribute('type', 'hidden');
            hiddenInput.setAttribute('name', 'stripeToken');
            hiddenInput.setAttribute('value', token.id);
            form.appendChild(hiddenInput);
        
            // Submit the form
            form.submit();
        }
    </script>
</body>

</html>