<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Author;

class Book extends Model
{

    /**
     * @var string
     */
    protected $table = 'books';


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title','isbn','cover','price','author_id',
    ];


    /**
     * A Book belongs to an Author
     * Relate back to the Author ID
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function Author() {
        return $this->belongsTo('App\Author', 'id');
    }

}