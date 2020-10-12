<?php

namespace App;

use App\Type;
use App\Booking;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{

    protected $table = 'rooms';
    protected $fillable = ['type_id','no_room','status'];

    // room x type
    public function types(){
        return $this->belongsTo(Type::class,'type_id');
    }

    //room x booking
    public function bookings(){
        return $this->belongsToMany(Booking::class,'booking_rooms');
    }






}
