<?php

namespace App\Http\Controllers;

use App\Cart;
use App\Order;
use Stripe\Stripe;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use Illuminate\Routing\Controller as BaseController;

class OrderController extends BaseController {


    /**
     * @param Request $request
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function postOrder(Request $request) {

        // Validate each form field
        $validator = Validator::make($request->all(), [
            'address'   => 'required|max:50|min:6',
            'full_name'      => 'required|max:30|min:2',
        ]);

        // If error occurs, display it
        if ($validator->fails()) {
            return redirect('/cart')
                ->withErrors($validator)
                ->withInput();
        }

        // Set your secret key: remember to change this to your live secret key in production
        Stripe::setApiKey('your secret key');

        // Set address and name to the the form fields so we can store them in DB
        $address = Input::get('address');
        $name = Input::get('full_name');

        // Set $member_id to the currently authenticated user
        $member_id = Auth::user()->id;

        // Set $cart_books to the Cart Model where the member_id = the current id of user and get the results
        $cart_books = Cart::with('books')->where('member_id', '=', $member_id)->get();

        // Set $cart_total to the Cart Model where the member_id = the current id of user, then get the sum of the total field
        $cart_total = Cart::with('books')->where('member_id', '=', $member_id)->sum('total');


        $charge_amount = number_format($cart_total, 2) * 100;

        // Create the charge on Stripe's servers - this will charge the user's card
        try {

            $charge = \Stripe\Charge::create(array(
                'source' => $request->input('stripeToken'),
                'amount' => $charge_amount, // amount in cents, again
                'currency' => 'usd',
            ));

        } catch(\Stripe\Error\Card $e) {
            // The card has been declined
            echo $e;
        }

        // Create the Order, and assign each variable to the correct form fields
        $order = Order::create (
            array (
                'member_id' => $member_id,
                'address'   => $address,
                'total'     => $cart_total,
                'full_name'      => $name,
            ));

        // Attache all cart items to the pivot table with their amount, price, and total amounts
        foreach ($cart_books as $order_books) {
            $order->orderItems()->attach($order_books->book_id, array(
                'amount' => $order_books->amount,
                'price'  => $order_books->books->price,
                'total'  => $order_books->books->price * $order_books->amount
            ));
        }

        // Delete all the items in the cart after transaction successful
        Cart::where('member_id', '=', $member_id)->delete();

        // Then return redirect back with success message
        flash()->success('Success', 'Your order was processed successfully.');
        return redirect()->route('index');
    }


    /**
     * @return mixed
     */
    public function getIndex(){

        // Set $member_id to the currently authenticated user
        $member_id = Auth::user()->id;

        // if the user is a admin get all orders, else just get the orders for the logged in user
        if (Auth::user()->admin){
            $orders = Order::all();
        } else{
            $orders = Order::with('orderItems')->where('member_id', '=', $member_id)->get();
        }

        return view('order')->with('orders', $orders);
    }


}