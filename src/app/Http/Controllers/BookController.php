<?php

namespace App\Http\Controllers;

use App\Book;
use App\Author;
use Illuminate\Routing\Controller as BaseController;

class BookController extends BaseController {


    public function getIndex() {

        $books = Book::all();

        //return view::make('book_list')->with('books', $books);

        return view('book_list')->with('books', $books);
    }

}