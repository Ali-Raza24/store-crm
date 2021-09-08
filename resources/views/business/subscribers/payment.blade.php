@extends('layouts.app')

@section('css')
    <style>
        /* Variables */
        * {
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, sans-serif;
            font-size: 16px;
            -webkit-font-smoothing: antialiased;
            display: flex;
            justify-content: center;
            align-content: center;
            height: 100vh;
            width: 100vw;
        }

        form {
            width: 30vw;
            min-width: 500px;
            align-self: center;
            box-shadow: 0px 0px 0px 0.5px rgba(50, 50, 93, 0.1),
            0px 2px 5px 0px rgba(50, 50, 93, 0.1), 0px 1px 1.5px 0px rgba(0, 0, 0, 0.07);
            border-radius: 7px;
            padding: 40px;
        }

        input {
            border-radius: 6px;
            margin-bottom: 6px;
            padding: 12px;
            border: 1px solid rgba(50, 50, 93, 0.1);
            height: 44px;
            font-size: 16px;
            width: 100%;
            background: white;
        }

        .result-message {
            line-height: 22px;
            font-size: 16px;
        }

        .result-message a {
            color: rgb(89, 111, 214);
            font-weight: 600;
            text-decoration: none;
        }

        .hidden {
            display: none;
        }

        #card-error {
            color: rgb(105, 115, 134);
            text-align: left;
            font-size: 13px;
            line-height: 17px;
            margin-top: 12px;
        }

        #card-element {
            border-radius: 4px 4px 0 0 ;
            padding: 12px;
            border: 1px solid rgba(50, 50, 93, 0.1);
            height: 44px;
            width: 100%;
            background: white;
        }

        #payment-request-button {
            margin-bottom: 32px;
        }

        /* Buttons and links */
        button {
            background: #5469d4;
            color: #ffffff;
            font-family: Arial, sans-serif;
            border-radius: 0 0 4px 4px;
            border: 0;
            padding: 12px 16px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            display: block;
            transition: all 0.2s ease;
            box-shadow: 0px 4px 5.5px 0px rgba(0, 0, 0, 0.07);
            width: 100%;
        }
        button:hover {
            filter: contrast(115%);
        }
        button:disabled {
            opacity: 0.5;
            cursor: default;
        }

        /* spinner/processing state, errors */
        .spinner,
        .spinner:before,
        .spinner:after {
            border-radius: 50%;
        }
        .spinner {
            color: #ffffff;
            font-size: 22px;
            text-indent: -99999px;
            margin: 0px auto;
            position: relative;
            width: 20px;
            height: 20px;
            box-shadow: inset 0 0 0 2px;
            -webkit-transform: translateZ(0);
            -ms-transform: translateZ(0);
            transform: translateZ(0);
        }
        .spinner:before,
        .spinner:after {
            position: absolute;
            content: "";
        }
        .spinner:before {
            width: 10.4px;
            height: 20.4px;
            background: #5469d4;
            border-radius: 20.4px 0 0 20.4px;
            top: -0.2px;
            left: -0.2px;
            -webkit-transform-origin: 10.4px 10.2px;
            transform-origin: 10.4px 10.2px;
            -webkit-animation: loading 2s infinite ease 1.5s;
            animation: loading 2s infinite ease 1.5s;
        }
        .spinner:after {
            width: 10.4px;
            height: 10.2px;
            background: #5469d4;
            border-radius: 0 10.2px 10.2px 0;
            top: -0.1px;
            left: 10.2px;
            -webkit-transform-origin: 0px 10.2px;
            transform-origin: 0px 10.2px;
            -webkit-animation: loading 2s infinite ease;
            animation: loading 2s infinite ease;
        }

        @-webkit-keyframes loading {
            0% {
                -webkit-transform: rotate(0deg);
                transform: rotate(0deg);
            }
            100% {
                -webkit-transform: rotate(360deg);
                transform: rotate(360deg);
            }
        }
        @keyframes loading {
            0% {
                -webkit-transform: rotate(0deg);
                transform: rotate(0deg);
            }
            100% {
                -webkit-transform: rotate(360deg);
                transform: rotate(360deg);
            }
        }

        @media only screen and (max-width: 600px) {
            form {
                width: 80vw;
            }
        }

    </style>
@endsection

@section('content')
    <div class="row m-0">
        <div class="col-12 p-0">
            <div class="login-left login-left-full">
                <a href="javscript:void(0)" class="brand-logo brand-sm">
                    <img alt="" src="{{asset('images/yabee_logo_1.png')}}">
                </a>
            </div>
        </div>
    </div>
    @php
    $planPrice = 0;
        if ($planType == 1) {
            $planPrice = $plan->monthly_price;
        }else{
            $planPrice = $plan->yearly_price;
        }
    @endphp
    <div class="row m-0 justify-content-center">
        <div class="col-12 p-0 mt-5">
            <div class="form-area d-flex align-items-center justify-content-center h-100">
                <div id="payment-request">
                    <div id="payment-request-button"></div>
                </div>
                <form id="payment-form" action="{{route('subscribe.post')}}" method="post" class="outh-form" >
                    @csrf
                    <input type="hidden" name="plan_type" value="{{$planType}}">
                    @if ($planType == 1)
                        <input type="hidden" name="plan" value="{{$plan->stripe_monthly_id}}">
                    @else
                        <input type="hidden" name="plan" value="{{$plan->stripe_yearly_id}}">
                    @endif

                    <div class="row">
                        <div class="col-6">
                            <strong>Customer:</strong> {{$business->name}}
                        </div>
                        <div class="col-6 text-right">
                            <p><strong>Plan:</strong> {{$plan->title}}</p>
                            <p><strong>Price:</strong> $ @if ($planType == 1) {{$plan->monthly_price}} @else {{$plan->yearly_price}} @endif</p>
                            <hr>
                            <p><strong>Plan Type:</strong> @if($planType == 1) Monthly @else Yearly @endif
                        </div>
                    </div>
                    <div id="card-element"></div>
                    <button id="card-button" data-secret="{{ $intent->client_secret }}">
                        <div class="spinner hidden" id="spinner"></div>
                        <span id="button-text">Pay now</span>
                    </button>
                    <p id="card-error" role="alert"></p>
                    <p class="result-message hidden">
                        Payment succeeded, see the result in your
                        <a href="" target="_blank">Stripe dashboard.</a> Refresh the page to pay again.
                    </p>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    @include('layouts.jquery')
    <script src="https://js.stripe.com/v3"></script>

    <script>
      const stripe = Stripe('{{config('cashier.key')}}');
      const style = {
        base: {
          iconColor: '#666ee8',
          color: '#31325f',
          fontWeight: 400,
          fontFamily:
            '-apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Oxygen-Sans, Ubuntu, Cantarell, "Helvetica Neue", sans-serif',
          fontSmoothing: 'antialiased',
          fontSize: '15px',
          '::placeholder': {
            color: '#aab7c4',
          },
          ':-webkit-autofill': {
            color: '#666ee8',
          },
        },
      };
      const elements = stripe.elements();
      const cardElement = elements.create('card',{style, hidePostalCode: true});

      cardElement.mount('#card-element');

      // const cardHolderName = document.getElementById('card-holder-name');
      const cardButton = document.getElementById('card-button');
      const clientSecret = cardButton.dataset.secret;

      const paymentRequest = stripe.paymentRequest({
        country: 'AE',
        currency: 'aed',
        total: {
          label: 'Total',
          amount: parseInt('{{$planPrice}}'),
        }
      });

      var prButton = elements.create('paymentRequestButton', {
        paymentRequest: paymentRequest,
      });

      paymentRequest.canMakePayment().then(function(result) {
        if (result) {
          prButton.mount('#payment-request-button');
        } else {
          document.getElementById('payment-request-button').style.display = 'none';
        }
      });

      cardButton.addEventListener('click', async (e) => {
        e.preventDefault();
        const { setupIntent, error } = await stripe.confirmCardSetup(
          clientSecret, {
            payment_method: {
              card: cardElement
            }
          }
        );

        if (error) {
          var errorElement = document.getElementById('card-error')
          errorElement.textContent = error.message
          return;
        } else {
          stripeTokenHandler(setupIntent)
          // The card has been verified successfully...
        }
      });

      /*var form  = document.getElementById('payment-form');

      form.addEventListener('submit', function(event) {
        event.preventDefault();

        stripe.createToken(cardElement).then(function(result) {
          if (result.error){
            var errorElement = document.getElementById('card-error');
            errorElement.textContent = result.error.message;
          } else {
            stripeTokenHandler(result.token)
          }
        })
      })*/

      function stripeTokenHandler(setupIntent) {
        var form = document.getElementById('payment-form');
        var hiddenInput = document.createElement('input');
        hiddenInput.setAttribute('type', 'hidden');
        hiddenInput.setAttribute('name', 'paymentMethod');
        hiddenInput.setAttribute('value', setupIntent.payment_method);
        form.appendChild(hiddenInput)

        form.submit();
      }
    </script>

    <script src="{{asset('vendor/jsvalidation/js/jsvalidation.min.js')}}"></script>
    {!! \Proengsoft\JsValidation\Facades\JsValidatorFacade::formRequest('App\Http\Requests\PaymentRequest', '#payment-form') !!}

@endsection
