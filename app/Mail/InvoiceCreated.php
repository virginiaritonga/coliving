<?php

namespace App\Mail;

use App\Booking;
use App\Invoice;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class InvoiceCreated extends Mailable
{
    use Queueable, SerializesModels;

    public $invoice;
    public $booking;
    // public $tenants;
    // public $rooms;
    public $rent_days;
    public $subtotal_room;
    public $total_payment;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Invoice $invoice)
    {
        $this->invoice = $invoice;
        $booking = Booking::with('tenants','rooms')->find($invoice->id);
        $rent_days = $invoice->countRentDays($booking->checkin_date, $booking->checkout_date);
        $subtotal_room = $invoice->countSubTotalRoomPrice($invoice->booking_id);
        $total_payment = $invoice->countTotalPayment($invoice);

        $this->booking = $booking;
        $this->rent_days = $rent_days;
        $this->subtotal_room = $subtotal_room;
        $this->total_payment = $total_payment;

    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('mail.invoice-created');
    }
}
