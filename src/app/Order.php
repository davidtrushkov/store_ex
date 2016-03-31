<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{

    /**
     * @var string
     */
    protected $table = 'orders';


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'full_name', 'member_id', 'address', 'total',
    ];


    /**
     * An Order can have many books
     *
     * @return $this
     */
    public function orderItems() {
        return $this->belongsToMany('App\Book')->withPivot('amount', 'price', 'total');
    }

}