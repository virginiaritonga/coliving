<?php

use Illuminate\Support\Facades\Route;



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

Route::get('/', function () {
    return view('welcome');
});

//authentication
Auth::routes(['register' =>false]);

Route::group(['middleware' => 'auth'], function () {
    //profile
    Route::resource('/profile','ProfileController');
    //home
    Route::get('/home', 'HomeController@index')->name('home');
    //type
    Route::resource('type', 'TypeController');
    //search-room
    Route::get('/search-room', 'RoomController@search')->name('search-room');
    //get description of room
    Route::get('/description-room', 'RoomController@getDesc')->name('room.description');
    //room
    Route::resource('room', 'RoomController');
    Route::get('type/{typeID}/create','RoomController@create_from_types')->name('type.create-room');
    Route::post('type/{typeID}/store','RoomController@store_from_types')->name('type.store-room');
    //tenant
    Route::resource('tenant', 'TenantController');
    //booking
    Route::resource('booking', 'BookingController');
    Route::get('booking/{bookingID}/print','BookingController@generateBooking')->name('booking.print');
    Route::get('/status/update', 'BookingController@updateStatusBooking')->name('booking.update.status');
    Route::get('/room-book/update', 'BookingController@updateRoomBooking')->name('booking.update.room');
    //invoice
    Route::resource('invoice', 'InvoiceController');
    Route::get('invoice/create/{bookingID}','InvoiceController@create')->name('invoice.create');
    Route::post('invoice/store/{bookingID}','InvoiceController@store')->name('invoice.store');
    Route::get('invoice/{invoiceID}/print','InvoiceController@generateInvoice')->name('invoice.print');
    //report
    Route::resource('report', 'ReportController');

    //mail to tenant
    Route::get('/mail-booking','Mail\BookingMailController@index')->name('mail-booking');
    Route::get('/mail-invoice','Mail\InvoiceMailController@index')->name('mail-invoice');
});

