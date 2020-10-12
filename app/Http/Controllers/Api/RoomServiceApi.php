<?php

namespace App\Http\Controllers\Api;

use App\Room;
use App\Booking;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RoomServiceApi extends Controller
{
    /**
     *
     *
     * @param yyyy-mm-dd,yyyy-mm-dd
     */
    public function getRoom(Request $request){
        if(request()->ajax()){
            if(!empty($request->checkin_date) && !empty($request->checkout_date)){

                if($request->input('checkin_date') > $request->input('checkout_date')){
                    return redirect()->back()->with(['error' => "Check-in Date can't be more than the Check-out Date"]);
                }

                $times = [
                    Carbon::parse($request->input('checkin_date')),
                    Carbon::parse($request->input('checkout_date')),
                ];

                $booking_id = $request->input('booking_id');

                $rooms = Room::where('status','!=','maintenance')
                ->WhereDoesntHave('bookings', function($query) use ($times){
                        $query->whereBetween('checkin_date',$times)
                            ->orWhereBetween('checkout_date',$times)
                            ->orWhere(function ($query) use ($times){
                                $query->where('checkin_date', '<', $times[0])
                                    ->where('checkout_date', '>' , $times[1]);
                            });
                })
                ->orwhereHas('bookings', function($query) use ($times,$booking_id){
                    $query->where('checkin_date', '=', $times[0])
                    ->where('checkout_date', '=' , $times[1])
                    ->where('booking_id','=',$booking_id);
                })
                ->get();

            }

            foreach($rooms as $room){
                $room->type = $room->types->type_name;
                $room->rent_price = number_format($room->types->rent_price);
                $room->capacity = $room->types->capacity;
            }

            //passing data room id
            $bookings = Booking::find($booking_id);
            $room_selected_array = [];
            foreach($bookings->rooms as $room){
                $room_id = $room->id;
                array_push($room_selected_array, $room_id);
            }
            $room_selected = $room_selected_array;

            return datatables()->of($rooms)
            ->addColumn('actions', function ($room) use($room_selected) {
                if(in_array($room->id, $room_selected)){
                    return '<input type="button" class="btn btn-sm btn-primary " id="bookRoom"  value="Booked" data-room-id="'. $room->id.'" >';
                }else{
                    return '<input type="button" class="btn btn-sm btn-primary " id="bookRoom"  value="Book Room" data-room-id="'. $room->id.'" >';
                }
            })
            ->rawColumns(['actions'])
            ->make(true);

        }
    }


}
