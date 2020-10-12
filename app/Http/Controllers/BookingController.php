<?php

namespace App\Http\Controllers;

use App\Room;
use App\Tenant;
use App\Booking;
use Carbon\Carbon;
use PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BookingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $bookings = Booking::all();
        return view('bookings.index',compact('bookings'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $tenants = Tenant::all();

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

        return view('bookings.create', compact('rooms','tenants'));
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
            'checkin_date' => 'required|date',
            'checkout_date' => 'required|date',
            'status' => 'required',
            'tenant_id' => 'required',
            'room_id' => 'required'
        ],[
            'checkin_date.required' => 'Checkin Date must be filled',
            'checkout_date.required' => 'Checkout Date must be filled',
            'status.required' => 'Status required',
        ]);

        if ($validator->fails()) {
            return redirect()->route('booking.create')
                        ->withErrors($validator)
                        ->withInput();
        }

        try {
             //instansiasi Booking
            $bookings = new Booking($request->all());
            $bookings->booking_date = date("Y-m-d H:i:s");

            // store data
            if($bookings->save()){

                 //PIVOT booking_rooms
                foreach($request->tenant_id as $tenant => $id){
                    $data = ['tenant_id' => $id];
                    //menambahkan tenant_id ke tabel pivot booking_rooms
                    $bookings->tenants()->attach($data);
                    //menambahkan booking_id ke tabel pivot booking_rooms
                    $bookings->tenants()->attach($request->id);

                    Tenant::where('id',$data)->update([
                        'status' => 'active',
                    ]);

                }
                //PIVOT booking_rooms
                foreach(explode(",",$request->room_id) as $room => $id){
                    $data = ['room_id' => $id];
                    // menambahkan room_id ke tabel pivot booking_rooms
                    $bookings->rooms()->attach($data);
                    // menambahkan booking_id ke tabel pivot booking_rooms
                    $bookings->rooms()->attach($request->id);

                    if($request->status == 'checked-in'){
                        Room::where('id',$data)->update([
                            'status' => 'booked',
                        ]);
                    }
                }

                return redirect()->route('booking.index')->with('success','Data Booking successfully created!!');
            }

        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => $e->getMessage()]);
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Booking  $booking
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $bookings = Booking::with('tenants','rooms')->findOrFail($id);
        return view('bookings.show',compact('bookings'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Booking  $booking
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        $bookings = Booking::find($id);
        $tenants = Tenant::all();

        //menampilkan tenant yang sebelumnya dipilih
        $tenant_selected = [];
        foreach($bookings->tenants as $tenant){
            $tenant_selected[] = $tenant->id;
        }

        return view('bookings.edit',compact('bookings','tenants','tenant_selected'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Booking  $booking
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
          //validate
        $validator = Validator::make($request->all(), [
            'checkin_date' => 'required|date',
            'checkout_date' => 'required|date',
            'status' => 'required',
            'tenant_id' => 'required',
        ],[
            'checkin_date.required' => 'Checkin Date must be filled',
            'checkout_date.required' => 'Checkout Date must be filled',
            'status.required' => 'Status required',
            'tenant_id.required' => 'Tenant Name must be filled',
        ]);

        if ($validator->fails()) {
            return redirect()->route('booking.edit', $id)
                        ->withErrors($validator)
                        ->withInput();
        }

        try {
            //find id booking
            $bookings = Booking::findOrFail($id);

            foreach($request->tenant_id as $tenant => $id){
                $data = ['tenant_id' => $id];
                //menambahkan tenant_id ke tabel pivot booking_rooms
                $bookings->tenants()->sync($data,false);

                Tenant::where('id',$data)->update([
                    'status' => 'active',
                    ]);
            }

            foreach($bookings->tenants as $tenant){
                $tenant_id = $tenant->id;
                //detach tenat_id jika pilihan tenant_id yang sebelumnya sudah masuk di database, dibatalkan
                if(!in_array($tenant_id, $request->tenant_id)){
                    $bookings->tenants()->detach($tenant_id);

                    Tenant::where('id',$tenant_id)->update([
                        'status' => 'inactive',
                        ]);
                }
            }

            $bookings->update($request->all());

            foreach ($bookings->rooms as $room ) {
                if($request->status == 'checked-in'){
                    Room::where('id',$room->id)->update([
                        'status' => 'booked',
                    ]);
                }

                if($request->status == 'booked'){
                    Room::where('id',$room->id)->update([
                        'status' => 'available',
                    ]);
                }

            }

            return redirect()->route('booking.index')->with('success','Data Booking was updated.');
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => $e->getMessage()]);
        }

    }

    /**
     * update status booking in datatabel booking list
     */
    public function updateStatusBooking(Request $request)
    {
        $booking = Booking::findOrFail($request->booking_id);
        $booking->status = $request->status;
        $booking->save();

        foreach ($booking->rooms as $room ) {
            if($request->status == 'checked-in'){
                Room::where('id',$room->id)->update([
                    'status' => 'booked',
                ]);
            }

            if($request->status == 'checked-out' || $request->status == 'booked'){
                Room::where('id',$room->id)->update([
                    'status' => 'available',
                ]);

            }
        }

        foreach($booking->tenants as $tenant){
            if($request->status == 'checked-out'){
                Tenant::where('id',$tenant->id)->WhereDoesntHave('bookings', function($query){
                    $query->where('status','booked')->orWhere('status','checked-in');
                })
                ->update([
                    'status' => 'inactive',
                ]);
            }

            if($request->status == 'checked-in' || $request->status == 'booked'){
                Tenant::where('id',$tenant->id)->update([
                    'status' => 'active',
                ]);
            }
        }

        return response()->json(['message' => 'Status booking updated successfully.']);
    }

     /**
     * update room booking in edit booking
     */
    public function updateRoomBooking(Request $request){
        $bookings = Booking::findOrFail($request->booking_id);
        if($request->status_booking == 'Booked'){
            $bookings->rooms()->attach($request->room_id);
            return response()->json(['message' => 'Room selected.']);
        }else{
            $bookings->rooms()->detach($request->room_id);
            return response()->json(['message' => 'Room not selected.']);
        }


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Booking  $booking
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $bookings = Booking::findOrFail($id);

        $bookings->rooms()->detach();
        $bookings->tenants()->detach();

        if(!$bookings->delete()){
            return redirect()->route('booking.index')->with('error','Something wrong!!');
        }
        return redirect()->back()->with(['success' => 'Data booking <strong>#'.$bookings->id.'</strong> deleted successfully!!']);
    }

    /**
     * function for generate booking into pdf
     *
     * @param  booking id
     * @return pdf stream
     */
    public function generateBooking($id){
        //Get data invoice berdasarkan ID
        $bookings = Booking::with('tenants','rooms')->find($id);
        $tenants = $bookings->tenants;
        $rooms = $bookings->rooms;
        $pdf = PDF::loadView('bookings.booking-pdf', compact('bookings','tenants','rooms',))->setPaper('a5', 'landscape');
        return $pdf->stream('Booking #'.$bookings->id);
    }


}
