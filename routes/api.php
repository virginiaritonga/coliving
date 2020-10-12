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

Route::group(['prefix' => 'v1'], function() {
    //report
    Route::get('booking-data/{date}', 'Api\BookingChartsApiController@getMonthlyBookingData');
    Route::get('daily-income-data/{month}', 'Api\IncomeChartsApiController@getDailyIncomeData');
    Route::get('monthly-income-data/{year}', 'Api\IncomeChartsApiController@getMonthlyIncomeData');
    Route::get('yearly-income-data/{start_date}/{end_date}', 'Api\IncomeChartsApiController@getYearlyIncomeData');
    Route::get('income-datatable', 'Api\IncomeChartsApiController@getIncome');
    //income by type
    Route::get('income-by-type', 'Api\IncomeChartsApiController@getIncomeByType');
    //list available room
    Route::get('list-available-room', 'Api\RoomServiceApi@getRoom');

});

