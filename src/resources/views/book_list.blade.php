@extends('main_layout')

@section('content')

    <div class="container">
        <div class="col-md-12">
            <div class="row">
                <ul class="thumbnails">
                    @foreach($books as $book)
                        <div class="col-xs-12 col-sm-6 col-md-4">
                            <div class="thumbnail">
                                <img src="/store_ex/src/public/images/requiem.jpg" alt="ALT NAME" class="img-responsive">
                                <div class="caption text-center">
                                    <h3>{{$book->title}}</h3>
                                    <p>Author : <b>{{$book->author->name}} {{$book->author->surname}}</b></p>
                                    <p>Price : $<b>{{$book->price}}</b></p>

                                    <form action="/store_ex/cart/add" name="add_to_cart" method="post">
                                        {!! csrf_field() !!}
                                        <input type="hidden" name="book" value="{{$book->id}}" />
                                        <select name="amount" class="form-control">
                                            <option value="1">1</option>
                                            <option value="2">2</option>
                                            <option value="3">3</option>
                                            <option value="4">4</option>
                                            <option value="5">5</option>
                                        </select>
                                        <br><br>
                                       <button class="btn btn-success">Add to Cart</button>
                                    </form>

                                </div>
                            </div>
                        </div>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>

@stop