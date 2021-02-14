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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['middleware' => ['cors', 'json.response']], function () {
    Route::post('/login', 'Api\AuthController@login')->name('api.login');

    Route::post('/register','Api\AuthController@register')->name('api.register'); 
    
    Route::post('/transaksi/save','Api\TransactionController@saveTransaction')->name('api.transaksi.save');
    
    Route::get('/transaksi/check/{disburseId}','Api\TransactionController@checkStatus')->name('api.transaksi.check'); 

    Route::get('/test','Api\TransactionController@test')->name('api.test'); 
});

Route::middleware('auth:api')->group(function () {
	Route::post('/logout', 'Api\AuthController@logout')->name('api.logout');
});