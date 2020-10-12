<?php

namespace App;

use App\Room;
use Illuminate\Database\Eloquent\Model;

class Type extends Model
{

    protected $table = 'types';
    protected $fillable = ['type_name','capacity','rent_price', 'description'];

    // type x room
    public function rooms(){
        return $this->hasMany(Room::class);
    }
}
