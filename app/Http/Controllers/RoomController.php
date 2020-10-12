<?php

namespace App\Http\Controllers;

use App\Room;
use App\Type;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RoomController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $rooms = Room::all();
        return view('rooms.index',compact('rooms'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create_from_types($id)
    {
        $types = Type::find($id);
        return view('rooms.create-room',compact('types'));
    }

     /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $types = Type::all();
        return view('rooms.create',compact('types'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store_from_types(Request $request)
    {
        //validate
        $validator = Validator::make($request->all(), [
            'type_id' => 'required|numeric',
            'no_room' => 'required',
            'status' => 'required'
        ],[
            'no_room.required' => 'Room Number must be filled',
            'status.required' => 'Status required',
        ]);

        if ($validator->fails()) {
            return redirect()->route('type.create-room',$request->type_id)
                        ->withErrors($validator)
                        ->withInput();
        }

        try{
            $room = Room::where('no_room','=',$request->no_room)->where('type_id','=',$request->type_id)->first();
            if($room != null){
                return redirect()->back()->with(['error' => 'Room already exists!']);
            }else{

                //instansiasi rooms
                $rooms = new Room($request->all());

                // store data
                $rooms->save();

                return redirect()->route('type.show',$request->type_id)->with('success','Data Room was created successfully!!');
            }

        }catch(\Exception $e){
            return redirect()->back()->with(['error' => $e->getMessage()]);
        }

    }

     /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //validate
        $validator = Validator::make($request->all(), [
            'type_id' => 'required|numeric',
            'no_room' => 'required',
            'status' => 'required'
        ],[
            'no_room.required' => 'Room Number must be filled',
            'status.required' => 'Status required',
        ]);

        if ($validator->fails()) {
            return redirect()->route('room.create')
                        ->withErrors($validator)
                        ->withInput();
        }

        try{
            //checking room already exist or not
            $room = Room::where('no_room','=',$request->no_room)->where('type_id','=',$request->type_id)->first();
            if($room != null){
                return redirect()->back()->with(['error' => 'Room already exists!']);
            }else{

                //instansiasi rooms
                $rooms = new Room($request->all());

                // store data
                $rooms->save();

                return redirect()->route('room.index')->with('success','Data Room created successfully!!');
            }

        }catch(\Exception $e){
            return redirect()->back()->with(['error' => $e->getMessage()]);
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Room  $room
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $rooms = Room::with('bookings')->find($id);
        return view('rooms.show',compact('rooms'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Room  $room
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $rooms = Room::find($id);
        $types = Type::all();
        return view('rooms.edit',compact('rooms','types'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Room  $room
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

         //validate
        $validator = Validator::make($request->all(), [
            'type_id' => 'required|numeric|exists:types,id',
            'no_room' => 'required',
            'status' => 'required'
        ],[
            'no_room.required' => 'Room Number must be filled',
            'status.required' => 'Status required',
        ]);

        if ($validator->fails()) {
            return redirect()->route('room.edit',$id)
                        ->withErrors($validator)
                        ->withInput();
        }


        try {

            //find id
            $rooms = Room::findOrFail($id);

            $room = Room::where('no_room','=',$request->no_room)->where('type_id','=',$request->type_id)->first();
            if($room !== null && $rooms->no_room !== $request->no_room && $rooms->type_id !== $request->type_id){
                return redirect()->back()->with(['error' => 'Room already exists!']);
            }else{

                // update data
                $rooms->update($request->all());

                return redirect()->route('room.index')->with(['success'=>'Data updated successfully!!']);
            }

        } catch (\Exception $e) {
            return redirect()->back()->with(['error' =>$e->getMessage()]);
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Room  $room
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $rooms = Room::findOrFail($id);
        $rooms->delete();
        return redirect()->back()->with(['success'=>'Data Room <strong>'.$rooms->no_room.'</strong> type <strong>'.$rooms->types->type_name.'</strong> deleted successfully!']);
    }

    public function search(Request $request){
        $rooms = null;
        if($request->filled(['checkin_date', 'checkout_date'])) {

            if($request->input('checkin_date') > $request->input('checkout_date')){
                return redirect()->back()->with(['error' => "Check-in Date can't be more than the Check-out Date"]);
            }

            $times = [
                Carbon::parse($request->input('checkin_date')),
                Carbon::parse($request->input('checkout_date')),
            ];

            $rooms = Room::where('status','!=','maintenance')->whereDoesntHave('bookings', function($query) use ($times){
                    $query->whereBetween('checkin_date',$times)
                        ->orWhereBetween('checkout_date',$times)
                        ->orWhere(function ($query) use ($times){
                            $query->where('checkin_date', '<', $times[0])
                                ->where('checkout_date', '>' , $times[1]);
                        });
                    })->get();
        }

        return view('rooms.search-room', compact('rooms'));
    }

    public function getDesc(Request $request){
        $room = Room::findOrFail($request->room_id);
        $description = $room->types->description;

        return response()->json(['description' => $description]);
    }
}
