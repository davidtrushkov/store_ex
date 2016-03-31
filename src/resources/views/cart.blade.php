@extends('main_layout')

@section('content')

    <div class="container">
        <h1>Your Cart</h1>
        @if ($cart_total === 0)
            <a href="{{ route('index') }}" class="list-group-item list-group-item-danger"> No books in your cart</a><br>
            <a href="{{ route('index') }}">Back</a>
        @else
        <table class="table">
            <tbody>
            <tr>
                <td>
                    <b>Title</b>
                </td>
                <td>
                    <b>Amount</b>
                </td>
                <td>
                    <b>Price</b>
                </td>
                <td>
                    <b>Total</b>
                </td>
                <td>
                    <b>Delete</b>
                </td>
            </tr>
                @foreach($cart_books as $cart_item)
                    <tr>
                        <td>{{$cart_item->books->title}}</td>
                        <td>
                            <form action="/store_ex/cart/up" method="post" role="form">
                                {!! csrf_field() !!}
                                <input type="hidden" name="book" value="{{$cart_item->books->id}}" />
                                <div class="col-md-4">
                                    <select name="amount" class="form-control">
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                        <option value="4">4</option>
                                        <option value="5">5</option>
                                    </select>
                                    <br>
                                    <button class="btn btn-sm btn-success">Update</button>
                                </div>
                                {{$cart_item->amount}}
                            </form>
                        </td>
                        <td>
                            $ {{$cart_item->books->price}}
                        </td>
                        <td>
                            $ {{$cart_item->total}}
                        </td>
                        <td>
                            <a href="{{URL::route('delete_book_from_cart', array($cart_item->id))}}">Delete</a>
                        </td>
                    </tr>
                @endforeach
            <tr>
                <td>
                </td>
                <td>
                </td>
                <td>
                    <b>Total</b>
                </td>
                <td>
                    <b>$ {{$cart_total}}</b>
                </td>
                <td>
                </td>
            </tr>
            </tbody>
        </table>
        @endif

        <a href="{{ route('index') }}" class="btn btn-primary">Continue Shopping</a>
    <br><br><br>

    @if ($cart_total === 0)

    @else
    <h3 class="text-center">Shipping & Checkout</h3><hr>

    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Credit card & shipping information</div>
                    <div class="panel-body">

                        <form id="payment-form" class="form-horizontal" role="form" method="POST" action="/store_ex/order">
                            {!! csrf_field() !!}

                            <div class="alert alert-danger payment-errors @if(!$errors->any()){{'hidden'}}@endif">
                                {{$errors->first('error')}}
                            </div>

                            <div class="form-group{{ $errors->has('address') ? ' has-error' : '' }}">
                                <label class="col-md-4 control-label">Address</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" size="20" name="address" value="{{ old('address') }}">
                                    @if ($errors->has('address'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('address') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('full_name') ? ' has-error' : '' }}">
                                <label class="col-md-4 control-label">Name On Card</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" size="20" name="full_name" value="{{ old('full_name') }}">
                                    @if ($errors->has('full_name'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('full_name') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-4 control-label">Card Number</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" size="20" data-stripe="number" >
                                    <h6>For test purposes enter: 4242 4242 4242 4242</h6>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-4 control-label">CVC</label>
                                <div class="col-md-3">
                                    <input type="text" class="form-control" size="4" data-stripe="cvc"/>
                                    <h6>For test purposes enter: 123</h6>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-4 control-label">Expiration (MM/YYYY)</label>
                                <div class="col-md-6">
                                    <input style="width: 20% !important; display: inline !important;" type="text" class="form-control" size="2" data-stripe="exp-month"/>
                                    <span style="font-size: 30px; vertical-align: middle">/</span>
                                    <input style="width: 40% !important; display: inline !important;" type="text" class="form-control" size="4" data-stripe="exp-year"/>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-md-6 col-md-offset-4">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fa fa-btn fa-arrow-right"></i> Continue
                                    </button>
                                </div>
                            </div>

                            <h6 class="text-center">
                                This payment system uses <a href="https://stripe.com/" target="_blank">Stripe</a>. To use Stripe,
                                you are going to have to set up a Stripe account to use Stripe and its keys.
                                This is set to a test environment in Stripe, so don't insert real credit card information.
                                Use the Test purpose numbers provided above.
                            </h6>

                        </form> <!-- close form -->
                    </div>  <!-- close panel-body -->
                    </div>  <!-- close panel-heading -->
                </div>  <!-- close panel-default -->
            </div>  <!-- close col-md-8 -->
        </div>  <!-- row -->
    </div>  <!-- close container -->
    @endif
@stop

@section('scripts.footer')
    <script type="text/javascript" src="https://js.stripe.com/v2/"></script>
    <script>

        // your Publishable key
        Stripe.setPublishableKey('your Publishable key');

        //
        jQuery(function($) {
            $('#payment-form').submit(function(event) {
                var $form = $(this);
                // Disable the submit button to prevent repeated clicks
                $form.find($('.btn')).prop('disabled', true);
                Stripe.card.createToken($form, stripeResponseHandler);
                // Prevent the form from submitting with the default action
                return false;
            });
        });

        //
        function stripeResponseHandler(status, response) {
            var $form = $('#payment-form');
            if (response.error) {
                // Show the errors on the form
                $form.find('.payment-errors').text(response.error.message);
                $form.find('.payment-errors').removeClass("hidden");
                $form.find($('.btn')).prop('disabled', false);
            } else {
                // response contains id and card, which contains additional card details
                var token = response.id;
                // Insert the token into the form so it gets submitted to the server
                $form.append($('<input type="hidden" name="stripeToken" />').val(token));
                // and submit
                $form.get(0).submit();
            }
        }

    </script>
@stop