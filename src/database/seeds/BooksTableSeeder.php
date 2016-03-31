<?php

use App\Book;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BooksTableSeeder extends Seeder {

    public function run()
    {
        DB::table('books')->delete();

        Book::create(array(
            'title'=>'Requiem',
            'isbn'=>'9780062014535',
            'price'=>'13.40',
            'cover'=>'requiem.jpg',
            'author_id'=>1
        ));
        Book::create(array(
            'title'=>'Twilight',
            'isbn'=>'9780316015844',
            'price'=>'15.40',
            'cover'=>'twilight.jpg',
            'author_id'=>2
        ));
        Book::create(array(
            'title'=>'Deception Point',
            'isbn'=>'9780671027384',
            'price'=>'16.40',
            'cover'=>'deception.jpg',
            'author_id'=>3
        ));

    }

}