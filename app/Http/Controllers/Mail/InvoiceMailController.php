<?php

namespace App\Http\Controllers\Mail;

use App\Invoice;
use App\Booking;
use App\Mail\InvoiceCreated;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;

class InvoiceMailController extends Controller
{
    public function index(Request $request){

        $invoice = Invoice::findOrFail($request->invoice_id);
        $booking = Booking::with('tenants','rooms')->find($invoice->booking_id);

        // send mail detail invoice to tenant
        foreach($booking->tenants as $tenants){
            Mail::to($tenants->email)->send(new InvoiceCreated($invoice));
        }

        return response()->json(['message' => 'Email Sent.']);
    }
}
