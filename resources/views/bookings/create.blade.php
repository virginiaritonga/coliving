@extends('layouts.layout')

@section('content')
<div class="card shadow mb-4 ">
    <div class="card-header py-3">
        <h5 class="m-0 font-weight-bold text-primary">Add New Booking </h5>
    </div>
    <div class="card-body">
        @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show">
            {!! session('error') !!}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        @endif

        {{-- form search room --}}
        <form id="searchRoom">
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="checkin_date">Checkin Date</label>
                        <input class="form-control" type="datetime-local" name="checkin_date" id="checkin_date" value="{{ request()->input('checkin_date') }}" placeholder="" required >
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="checkout_date">Checkout Date</label>
                        <input class="form-control" type="datetime-local" name="checkout_date" id="checkout_date" value="{{ request()->input('checkout_date') }}" placeholder="" required>
                    </div>
                </div>
                <div class="col-md-4" style="padding-top: 2rem">
                    <button class="btn btn-success">
                        Search
                    </button>
                </div>
            </div>
        </form>

            {{-- HASIL --}}
            @if($rooms !== null)
            <hr />
            @if($rooms->count())
                <div class="table-responsive">
                    <table class=" table table-bordered table-striped table-hover datatable datatable-Event" id="dataTable">
                        <thead>
                            <tr>
                                <th>
                                    No Room
                                </th>
                                <th>
                                    Capacity
                                </th>
                                <th>
                                    Type
                                </th>
                                <th>
                                    Rent Price
                                </th>
                                <th>
                                    &nbsp;
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($rooms as $room)
                                <tr>
                                    <td class="room-name">
                                        {{ $room->no_room ?? '' }}
                                    </td>
                                    <td>
                                        {{ $room->types->capacity ?? '' }}
                                    </td>
                                    <td>
                                        {{ $room->types->type_name ?? '' }}
                                    </td>
                                    <td>
                                        Rp. {{ number_format($room->types->rent_price) ?? '' }}
                                    </td>
                                    <td>
                                        <input type="button" class="btn btn-sm btn-primary " id="bookRoom"  data-room-id="{{ $room->id }}" value="Book Room">
                                    </td>

                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <p class="text-center">There are no rooms available at the time you have chosen</p>
            @endif
        @endif
        <hr>

        {{-- form create booking --}}
        <form method="POST" action="{{route('booking.store')}}" id="booking_form">
            @csrf
            <div class="form-group">
                <label for="booking_date">Booking Date</label>
                <input type="text" name="booking_date" id="booking_date" class="form-control" value="{{date('d F Y, h:i:s A')}}" {{$errors->has('booking_date') ? 'is-invalid' : ''}} disabled>
                <p class="text-danger">{{$errors->first('booking_date')}}</p>
            </div>
            <div class="form-group">
                <label for="tenant_id">Tenant Name</label>
                <select class="form-control select2bs4" name="tenant_id[]" multiple="multiple" data-placeholder="Pilih Tenant" style="width: 100%;" id="tenant_id" {{$errors->has('tenant_id') ? 'is-invalid' : ''}} >
                    @foreach ($tenants as $tenant)
                    <option value="{{$tenant->id}}">{{$tenant->tenant_name}} - {{$tenant->email}}</option>
                    @endforeach
                </select>
                <p class="text-danger">{{$errors->first('tenant_id')}}</p>
            </div>
            <div class="form-group">
                <label for="status">Status</label>
                <select class="form-control" name="status" id="status" {{$errors->has('status') ? 'is-invalid' : ''}}>
                    <option value="booked">booked</option>
                    <option value="checked-in">checkin</option>
                </select>
                <p class="text-danger">{{$errors->first('status')}}</p>
            </div>
            <div class="form-group">
                <input  hidden name="room_id" id="room_id" value="{{ old('room_id') }}"  {{$errors->has('room_id') ? 'is-invalid' : ''}}>
                <p class="text-danger">{{$errors->first('room_id')}}</p>
            </div>
            <input  hidden name="checkin_date" value="{{ request()->input('checkin_date') }}">
            <input  hidden name="checkout_date" value="{{ request()->input('checkout_date') }}">
            <hr>
            <button type="submit" name="add_booking" class="btn btn-primary">Add Booking</button>
            <button type="reset" class="btn btn-danger" name="reset">Reset</button>
            <a type="button" href="{{route('booking.index')}}" class="btn btn-secondary">Back</a>
        </form>


    </div>
</div>



@endsection

@push('scripts')
<script>
$(document).ready(function(){
    $('#dataTable').DataTable();
    //datatable Search Room
    var IDs = new Array();
    $("#dataTable").on('click','#bookRoom',function() {
        //get id room
        var roomId = $(this).attr("data-room-id");

        //jika memilih room untuk dibooking, ubah Book Room menjadi Booked dan masukkan id ke array IDs
        //jika batal memlih room untuk dibooking, ubah Booked menjadi Book Room dan hapus id dari array IDs
        if (this.value == 'Book Room'){
            this.value = "Booked";
            $(this).each(function(){ IDs.push(roomId); });
        }else{
            this.value = "Book Room";
            remove_array_element(IDs, roomId);
        }

        //send value IDs to form booking_form
        $('#booking_form').find('#room_id').val(IDs);

    });

    //function untuk menghapus elemen array (roomId) dari array IDs
    function remove_array_element(array, n)
    {
        var index = array.indexOf(n);
        if (index > -1) {
        array.splice(index, 1);
        }
        return array;
    }



});



</script>

@endpush
