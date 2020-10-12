<?php

namespace App;

use App\Room;
use App\Tenant;
use App\Invoice;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{

    protected $table = 'bookings';
    protected $fillable = ['booking_date','checkin_date','checkout_date','status'];


    // booking x tenants
    public function tenants(){
        return $this->belongsToMany(Tenant::class,'booking_tenants')->withTimestamps()->withPivot('booking_id','tenant_id');
    }

    // booking x rooms
    public function rooms(){
        return $this->belongsToMany(Room::class,'booking_rooms')->withTimestamps();
    }

    //booking x invoice
    public function invoices(){
        return $this->hasOne(Invoice::class);
    }


}
