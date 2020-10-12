@extends('layouts.layout')

@section('content')
<div class="card shadow mb-4 ">
    <div class="card-header py-3">
    <h5 class="m-0 font-weight-bold text-primary">Edit Booking #{{$bookings->id}}</h5>
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
                        <input class="form-control" type="datetime-local" name="checkin_date"  value="{{date('Y-m-d\TH:i', strtotime($bookings->checkin_date))}}" id="checkin_date_search" placeholder="" required >
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="checkout_date">Checkout Date</label>
                        <input class="form-control" type="datetime-local" name="checkout_date"  value="{{date('Y-m-d\TH:i', strtotime($bookings->checkout_date))}}" id="checkout_date_search" placeholder="" required>
                    </div>
                </div>
                <div class="col-md-4" style="padding-top: 2rem">
                    <button type="button" name="search" class="btn btn-success" id="search">
                        Search Available Room
                    </button>
                </div>
            </div>
        </form>

            {{-- HASIL --}}
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
                    </table>
                </div>
        <hr>

        {{-- form create booking --}}
        <form method="POST" action="{{route('booking.update', $bookings->id)}}" id="booking_form">
            @csrf
            {{ method_field('PUT') }}
            <div class="form-group">
                <label for="booking_date">Booking Date</label>
                <input type="text" name="booking_date" id="booking_date" class="form-control" value="{{$bookings->booking_date}}" {{$errors->has('booking_date') ? 'is-invalid' : ''}} readonly>
                <p class="text-danger">{{$errors->first('booking_date')}}</p>
            </div>
            <div class="form-group">
                <label for="tenant_id">Tenant Name</label>
                <select class="form-control select2bs4" name="tenant_id[]" multiple="multiple" data-placeholder="Pilih Tenant" style="width: 100%;" id="tenant_id" {{$errors->has('tenant_id') ? 'is-invalid' : ''}}>
                    @foreach ($tenants as $tenant)
                    @if(in_array($tenant->id, $tenant_selected))
                    <option value="{{$tenant->id}}" selected>{{$tenant->tenant_name}}</option>
                    @else
                    <option value="{{$tenant->id}}">{{$tenant->tenant_name}} - {{$tenant->email}}</option>
                    @endif
                    @endforeach
                </select>
                <p class="text-danger">{{$errors->first('tenant_id')}}</p>
            </div>
            <div class="form-group">
                <label for="status">Status</label>
                <select class="form-control" name="status" id="status" {{$errors->has('status') ? 'is-invalid' : ''}}>
                    @if($bookings->status == 'booked')
                    <option value="booked" selected>booked</option>
                    <option value="checked-in">checkin</option>
                    @elseif ($bookings->status == 'checked-in')
                    <option value="booked">booked</option>
                    <option value="checked-in" selected>checkin</option>
                    @endif
                </select>
                <p class="text-danger">{{$errors->first('status')}}</p>
            </div>
            <div class="form-group">
                <input hidden name="room_id" id="room_id" value="@foreach($bookings->rooms as $room) {{$room->id}} @endforeach " disabled>
            </div>
            <input hidden type="number" name="id" value="{{$bookings->id}}" id="booking_id" disabled>
            <input hidden type="text" name="checkin_date" value="{{$bookings->checkin_date}}" id="checkin_date">
            <input hidden type="text" name="checkout_date" value="{{$bookings->checkout_date}}" id="checkout_date">
            <hr>
            <button type="submit" name="add_booking" class="btn btn-primary">Update Booking</button>
            <button type="reset" class="btn btn-danger" name="reset">Reset</button>
            <a type="button" href="{{route('booking.index')}}" class="btn btn-secondary">Back</a>
        </form>


    </div>
</div>



@endsection

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script>

url_get_room = "{{ url('api/v1/list-available-room') }}";

$(document).ready(function(){
    //get value for load data pertama kali
    var checkin_date_search = $('#checkin_date_search').val();
    var checkout_date_search = $('#checkout_date_search').val();
    var booking_id = $('#booking_id').val();
    //first load data
    load_data(booking_id, checkin_date_search, checkout_date_search);
    //function load data
    function load_data(booking_id = '',checkin_date = '', checkout_date = '') {
        table_get_room = $('#dataTable').DataTable({
            ajax: {
                url: url_get_room,
                data: {
                    checkin_date: checkin_date,
                    checkout_date: checkout_date,
                    booking_id: booking_id
                }
            },
            columns: [
                {
                    data: 'no_room',
                    name: 'no_room'
                },
                {
                    data: 'capacity',
                    name: 'capacity'
                },
                {
                    data: 'type',
                    name: 'type',
                },
                {
                    data: 'rent_price',
                    name: 'rent_price',
                    defaultContent: '0',
                    render: function(data, type, row) {
                        return "Rp " + data;
                    },
                },
                {
                    data: 'actions',
                    name: 'actions',
                    sortable: false,
                },
            ],
            // language: {
            //     infoEmpty: "No records available - Got it?",
            // }
        });
    }

    //inisiasi array IDs
    var IDs = new Array();

    //isi IDs dengan value room id sebelumnya dari database
    var rooms = $('#room_id').val().trim().split(" ").join("").split("");
    $('#room_id').each(function(){
        for(i=0; i<rooms.length; i++){
            IDs.push(rooms[i]);
        }
    });
    // console.log(IDs);

    $("#dataTable").on('click','#bookRoom',function() {

        let roomId = $(this).attr("data-room-id");
        let bookingId = $('#booking_id').val();

        if (this.value == 'Book Room'){
            // $(" table tr #bookRoom[data-room-id='"+roomId+"'] ").val('Booked');
            $(this).val('Booked');
            $(this).each(function(){ IDs.push(roomId); });
        }else{
            $(this).val('Book Room');
            remove_array_element(IDs, roomId);
        }

        $('#booking_form').find('#room_id').val(IDs);

        //get value status booking room
        let status_booking = $(this).val();

        $.ajax({
            type: "GET",
            dataType: "json",
            url: '{{ route('booking.update.room') }}',
            data: {'status_booking':status_booking,'room_id': roomId, 'booking_id': bookingId},
            success: function (data) {
                toastr.options.closeButton = true;
                toastr.options.closeMethod = 'fadeOut';
                toastr.options.closeDuration = 100;
                toastr.success(data.message);
            },
            error: function(request, errorType, errorMsg){
                console.log("there was an issue with ajax call: " + errorMsg);
            },
        });

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

    //Checkin Datetime checking
    $('#checkin_date_search').change(function() {

        if (!Array.isArray(IDs) || IDs.length) {
            alert('If you want to change your checkin date, make sure to cancel your previous booking room');
            $('#checkin_date_search').val(checkin_date_search);
        }

        if ($('#checkin_date_search').val() > $('#checkout_date_search').val()) {
            alert("Checkin Date can't be more than the Checkout Date");
            $('#checkin_date_search').val(checkin_date_search);
        } else {
            checkin_date_search = $('#checkin_date_search').val();
        }

    });

    //Checkout Datetime checking
    $('#checkout_date_search').change(function() {

        if (!Array.isArray(IDs) || IDs.length) {
            alert('If you want to change your checkout date, make sure to cancel your previous booking room');
            $('#checkout_date_search').val(checkout_date_search);
        }

        if ($('#checkin_date_search').val() > $('#checkout_date_search').val()) {
            alert("Checkout Date can't be less than the Checkin Date");
            $('#checkout_date_search').val(checkout_date_search);
        } else {
            checkout_date_search = $('#checkout_date_search').val();
        }

    });


    //event search klik
    $('#search').click(function() {
        var checkin_date_search = $('#checkin_date_search').val();
        var checkout_date_search = $('#checkout_date_search').val();
        var booking_id = $('#booking_id').val();
        if (checkin_date_search != '' && checkout_date_search != '') {
            $('#dataTable').DataTable().destroy();
            load_data(booking_id, checkin_date_search, checkout_date_search);
        } else {
            alert('Both Date is required');
        }
        //submit value chekin and checkout date
        $('#checkin_date').val(checkin_date_search);
        $('#checkout_date').val(checkout_date_search);


    });




});




</script>

@endpush
