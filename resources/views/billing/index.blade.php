@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Subscribe</div>

                <div class="card-body">
                    <div class="row">
                        <form action="{{route('subscribe.post')}}" method="POST" id="payment-form" data-secret="{{ $intent->client_secret }}">
                            @csrf
                            <div class="w-1/2 form-row">
                                <label for="cardholder-name">Cardholder's Name</label>
                                <div>
                                    <input type="text" id="cardholder-name" class="px-2 py-2 border">
                                </div>
                                <div class="my-4">
                                    @foreach($plans as $index=>$plan)
                                    <input type="radio" name="plan" id="{{$plan->id}}" value="{{$plan->stripe_plan_id}}" {{$index==0?'checked':''}}>
                                    <label for="{{$plan->id}}">{{$plan->name}} - ${{$plan->price()  }} / {{$plan->billing_period}}</label> <br>
                                    @endforeach
                                </div>
                                <label for="card-element">
                                    Credit or debit card
                                </label>
                                <div id="card-element">
                                    <!-- A Stripe Element will be inserted here. -->
                                </div>
                                <div id="card-errors" role="alert"></div>
                                <button type="submit"  class="mt-4 btn btn-primary">Subscribe Now</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
    <script src="https://js.stripe.com/v3/"></script>

        <script>
            // Create a Stripe client.
            var stripe = Stripe('pk_test_51KgBBrJPFUiHiUaX6Ar3Q31AoBRijUWEMesFr0wh2BN7R2JbxNnoEbxreKVqWper7H1HyS43Kx0CwBpW8NL1zrfd002VFcDlA9');



            // Create an instance of Elements.
             var elements = stripe.elements();

            // Custom styling can be passed to options when creating an Element.
            // (Note that this demo uses a wider set of styles than the guide below.)
            var style = {
                base: {
                    color: '#32325d',
                    fontFamily: '"Helvetica Neue", Helvetica, sans-serif',
                    fontSmoothing: 'antialiased',
                    fontSize: '16px',
                    '::placeholder': {
                        color: '#aab7c4'
                    }
                },
                invalid: {
                    color: '#fa755a',
                    iconColor: '#fa755a'
                }
            };
            // Create an instance of the card Element.
            var card = elements.create('card', {style: style});
            // Add an instance of the card Element into the `card-element` <div>.
            card.mount('#card-element');
            // Handle real-time validation errors from the card Element.
            card.on('change', function(event) {

                var displayError = document.getElementById('card-errors');
                if (event.error) {
                    displayError.textContent = event.error.message;
                } else {
                    displayError.textContent = '';
                }
            });
            // Handle form submission.
            var form = document.getElementById('payment-form');
            var cardHolderName = document.getElementById('cardholder-name');
            var clientSecret = form.dataset.secret;
            form.addEventListener('submit', async function(event) {
                 event.preventDefault();

                const { setupIntent, error } = await stripe.confirmCardSetup(
                    clientSecret, {
                        payment_method: {
                            card,
                            billing_details: { name: cardHolderName.value }
                        }
                    }
                );
                if (error) {
                    // Inform the user if there was an error.
                    var errorElement = document.getElementById('card-errors');
                    errorElement.textContent = error.message;
                } else {

                    // Send the token to your server.
                    stripeTokenHandler(setupIntent);
                }

            });
            // Submit the form with the token ID.
            function stripeTokenHandler(setupIntent) {
                // Insert the token ID into the form so it gets submitted to the server
                var form = document.getElementById('payment-form');
                var hiddenInput = document.createElement('input');
                hiddenInput.setAttribute('type', 'hidden');
                hiddenInput.setAttribute('name', 'paymentMethod');
                hiddenInput.setAttribute('value', setupIntent.payment_method);
                form.appendChild(hiddenInput);
                // Submit the form
                 form.submit();
            }
        </script>


@endsection
