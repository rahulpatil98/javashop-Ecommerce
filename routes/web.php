<?php

use Illuminate\Support\Facades\Route;

use config\cart;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
/*
// Admin Routes
*/
Route::prefix('admin')->group(function(){


    Route::middleware('auth:admin')->group(function() {
        // Dashboard
        Route::get('/', 'DashboardController@index');

        // Products
        Route::resource('/products','ProductController');

        // Orders
        Route::resource('/orders','OrderController');
        Route::get('/confirm/{id}','OrderController@confirm')->name('order.confirm');
        Route::get('/pending/{id}','OrderController@pending')->name('order.pending');

        // Users
        Route::resource('/users','UserController');

        // Logout
        Route::get('/logout','AdminUserController@logout');

    });

    //Admin Login
    Route::get('/login','AdminUserController@index');
    Route::post('/login','AdminUserController@store');

});
    
/*
// Front End Routes
*/






Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');



Route::get('/', 'Front\HomeController@index');

//user registration

Route::get('/user/register','Front\RegistrationController@index');
Route::post('/user/register','Front\RegistrationController@store');

//user login

Route::get('/user/login','Front\SessionController@index');
Route::post('/user/login','Front\SessionController@store');

//logout

Route::get('/user/logout','Front\SessionController@logout');

Route::get('/user/profile','Front\UserProfileController@index');

Route::get('/user/order/{id}','Front\UserProfileController@show');

//cart

Route::get('/cart','Front\CartController@index');
Route::post('/cart','Front\CartController@store')->name('cart');
Route::patch('/cart/update/{product}','Front\CartController@update')->name('cart.update');
Route::delete('/cart/remove/{product}','Front\CartController@destroy')->name('cart.destroy');
Route::post('/cart/saveLater/{product}','Front\CartController@saveLater')->name('cart.saveLater');


//save for later

Route::delete('/saveLater/destroy/{product}','Front\SaveLaterController@destroy')->name('saveLater.destroy');
Route::post('/cart/moveToCart/{product}','Front\SaveLaterController@moveToCart')->name('moveToCart');


//checkout

Route::get('/checkout','Front\CheckoutController@index');
Route::post('/checkout','Front\CheckoutController@store')->name('checkout');



Route::get('empty',function(){
    Cart::instance('default')->destroy();
});