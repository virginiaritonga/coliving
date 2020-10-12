<?php

namespace App;

use App\Invoice;
use Illuminate\Database\Eloquent\Model;

class Tenant extends Model
{

    protected $table = 'tenants';
    protected $fillable = ['tenant_name','IDcard_number','type_IDcard','KTP_image','no_HP','address','status','email'];

    //tenant x booking
    public function bookings(){
        return $this->belongsToMany(Booking::class,'booking_tenants');
    }


}
