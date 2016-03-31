<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::group(['middleware' => ['web']], function () {

    Route::get('/', [
        'uses' => 'BookController@getIndex',
        'as'   => 'index'
    ]);

    Route::get('/login', [
        'uses' => '\App\Http\Controllers\AuthController@getLogin',
        'as'   => 'auth.login',
        'middleware' => ['guest']
    ]);

    Route::post('/login', [
        'uses' => '\App\Http\Controllers\AuthController@postLogin',
        'as'   => 'auth.login',
        'middleware' => ['guest']
    ]);

    Route::get('/logout', [
        'uses' => '\App\Http\Controllers\AuthController@logout',
        'as'   => 'main_layout',
    ]);


    Route::get('/cart',
        array(
            'before' => 'auth.basic',
            'as'     => 'cart',
            'uses'   => 'CartController@getIndex'
        ));

    Route::post('/cart/add',
        array(
            'before' => 'auth.basic',
            'uses'   => 'CartController@postAddToCart'
        ));

    Route::post('/cart/up', [
        'uses' => 'CartController@updateCart'
    ]);

    Route::get('/cart/delete/{id}',
        array(
            'before' => 'auth.basic',
            'as'     => 'delete_book_from_cart',
            'uses'   => 'CartController@getDelete'
        ));



    Route::post('/order',
        array(
            'before' => 'auth.basic',
            'as'     => 'order',
            'uses'   => 'OrderController@postOrder'
        ));


    Route::get('/user/orders',
        array(
            'before' => 'auth.basic',
            'as'     => 'myorder',
            'uses'   => 'OrderController@getIndex'
        ));





});
