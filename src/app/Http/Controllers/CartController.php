<?php

namespace App\Http\Controllers;

use App\Book;
use App\Cart;
use Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use App\Http\Controllers\Controller;
use Illuminate\Routing\Controller as BaseController;

class CartController extends Controller {


    public function __construct() {
        $this->middleware('auth');
        // Reference the main constructor.
        parent::__construct();
    }

    /**
     * Add Books to cart
     *
     * @return mixed
     */
    public function postAddToCart() {

        // Assign validation rules
        $rules = array(
            'amount' => 'required|numeric',
            'book'   => 'required|numeric|exists:books,id'
        );

        // Apply validation
        $validator = Validator::make(Input::all(), $rules);

        // If validation fails, show error message
        if ($validator->fails()) {
            flash()->error('Error', 'The book could not added to your cart!');
            return redirect()->route('index');
        }

        // Set member_id to the currently signed in user ID
        $member_id = Auth::user()->id;

        // Set book_id the the hidden book input field in form
        $book_id = Input::get('book');

        // Set the amount to the books amount
        $amount = Input::get('amount');

        // Get the ID of the Books in the cart
        $book = Book::find($book_id);

        // set total to amount * the book price
        $total = $amount * $book->price;

        // Create the Cart
        Cart::create (
            array (
                'member_id' => $member_id,
                'book_id'   => $book_id,
                'amount'    => $amount,
                'total'     => $total
            ));

        // Then redirect back
        return redirect()->route('cart');
    }


    /**
     * Update the cart
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateCart() {

        // Set member_id to the currently signed in user ID
        $member_id = Auth::user()->id;

        // Set the amount to the books amount
        $amount = Input::get('amount');

        // Set book_id the the hidden book input field in form
        $book_id = Input::get('book');

        // Get the ID of the Books in the cart
        $book = Book::find($book_id);

        // set total to amount * the book price
        $total = $amount * $book->price;
        
        // Select ALL from cart where the member_id = to the current logged in user, and where the book_id = the book ID being updated
        $cart = Cart::where('member_id', '=', $member_id)->where('book_id', '=', $book_id);

        // Update your cart
        $cart->update(array(
            'member_id' => $member_id,
            'book_id'   => $book_id,
            'amount'    => $amount,
            'total'     => $total
        ));

        return redirect()->route('cart');
    }


    /**
     * Return the Cart page with the cart items and total
     *
     * @return mixed
     */
    public function getIndex(){

        // Set the $member_id the the currently authenticated user
        $member_id = Auth::user()->id;

        // Set $cart_books to the member ID
        $cart_books = Cart::with('books')->where('member_id', '=', $member_id)->get();

        // Set $cart_total to the total in the Cart for that member ID to check and see if the cart is empty
        $cart_total = Cart::with('books')->where('member_id', '=', $member_id)->sum('total');

        // return the cart with books, and total amount in cart
        return view('cart')
            ->with('cart_books', $cart_books)
            ->with('cart_total', $cart_total);
    }


    /**
     * Delete a book from a users Cart
     *
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function getDelete($id){
        // Find the Carts table and given ID, and delete the record
        Cart::find($id)->delete();

        // Then redirect back home
        return redirect()->route('cart');
    }

}
