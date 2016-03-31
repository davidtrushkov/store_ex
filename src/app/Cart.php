<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{

    /**
     * @var string
     */
    protected $table = 'carts';


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'member_id', 'book_id', 'amount', 'total',
    ];


    public function Books() {
        return $this->belongsTo('App\Book', 'book_id');
    }

}