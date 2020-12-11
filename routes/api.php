<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:api')->get('/users', function (Request $request) {
//     return $request->user();
// });

Route::get('login', 'Api\UserController@login')->name('api.login');
Route::post('register', 'Api\UserController@register');
Route::group(['middleware' => 'auth:api'], function(){
Route::post('logout', 'Api\UserController@logout');

Route::get('users', 'Api\UserController@show');
Route::post('users', 'Api\UserController@update');
Route::get('users/getDeviceId', 'Api\UserController@getDeviceId');


Route::get('clothes', 'Api\ClothsController@index');
Route::get('orders/list', 'Api\OrdersController@orderlist');
Route::get('orders/activeorders', 'Api\OrdersController@activeorders');
Route::post('orders/new', 'Api\OrdersController@store');
Route::get('orders/send_notification', 'Api\OrdersController@send_notification');

Route::get('services', 'Api\ServiceController@index');
Route::get('services', 'Api\ServiceController@show');
Route::get('services/items', 'Api\ServiceController@getallservice');
});




