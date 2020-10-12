<?php

namespace App\Http\Controllers\Mail;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Booking;
use App\Mail\BookingCreated;
use Illuminate\Support\Facades\Mail;

class BookingMailController extends Controller
{
    public function index(Request $request){

        $booking = Booking::findOrFail($request->booking_id);

        // send mail detail booking to tenant
        foreach($booking->tenants as $tenants){
            Mail::to($tenants->email)->send(new BookingCreated($booking));
        }

        return response()->json(['message' => 'Email Sent.']);
    }
}




