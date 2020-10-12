<?php

namespace App;

use App\Room;
use App\Type;
use App\Booking;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{

    protected $table = 'invoices';
    protected $fillable = ['invoice_number','invoice_date','discount','additional_cost','is_paid','total_payment','payment_method','total_paid','booking_id'];

    //invoice x booking
    public function bookings(){
        return $this->belongsTo(Booking::class);
    }


      /**
     * count rent days
     *
     * @param  $booking_id
     * @return $rent_days
     */
    public function countRentDays($start, $end){

        //start
        $start_rent = Carbon::parse($start);
        //end
        $end_rent = Carbon::parse($end);
        //count total rent days use diffInDays()
        $rent_days  = $start_rent->diffInDays($end_rent);

        return $rent_days;
    }

    /**
     * count subtotal_room
     *
     * @param  $booking_id
     * @return $subtotal_room
     */
    public function countSubTotalRoomPrice($booking_id){
        $booking = new Booking;

        //find data booking based on booking id
        $bookings = $booking->with('rooms')->find($booking_id);

        //count rent days
        $rent_days  = $this->countRentDays($bookings->checkin_date, $bookings->checkout_date);

        //count subtotal room
        $subtotal_room = 0;
        foreach($bookings->rooms as $room){
            $subtotal_room += $room->types->rent_price * $rent_days;
        }
        return $subtotal_room;
    }

    /**
     * count total_payment
     *
     * @param  $invoice
     * @return $total_payment
     */
    public function countTotalPayment(Invoice $invoice){

        $subtotal_room = $this->countSubTotalRoomPrice($invoice->booking_id);
        $total_payment = ($subtotal_room + $invoice->additional_cost) - $invoice->discount;

        return $total_payment;
    }



}
