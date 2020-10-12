@extends('layouts.layout')

@section('content')
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h5 class="m-0 font-weight-bold text-primary">Detail Tenant</h5>
    </div>
    <div class="card-body">
        <p><strong>Full Name: </strong><br> <span class="text">{{$tenants->tenant_name}}</span></p>
        <p><strong>Email: </strong><br> <span class="text">{{$tenants->email}}</span></p>
        <p><strong>ID : </strong><br>
            <span class="text">{{$tenants->type_IDcard}} {{$tenants->IDcard_number}}</span><br>
        </p>
        <p><strong>Phone Number: </strong><br> <span class="text">{{$tenants->no_HP}}</span></p>
        <p><strong>Address: </strong><br> <span class="text">{{$tenants->address}}</span></p>
        <p><strong>Status: </strong><br> <span class="text">{{$tenants->status}}</span></p>

        <div>
            <h4 style="padding-bottom: 20px"> History Booking </h4>
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th scope="col">Booking ID</th>
                        <th scope="col">Booking Date</th>
                        <th scope="col">Room</th>
                        <th scope="col">Checked - in</th>
                        <th scope="col">Checked - Out</th>
                        <th scope="col">Status</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody id="myTable">
                    @foreach ($tenants->bookings as $booking)
                    <tr>
                        <td>{{$booking->id}}</td>
                        <td>{{date('d M Y H:i:s', strtotime($booking->booking_date))}}</td>
                        <td>
                            @foreach ($booking->rooms as $room)
                                <span>Type {{$room->types->type_name}} No. {{$room->no_room}}</span>
                            @endforeach
                        </td>
                        <td>{{date('d M Y H:i:s', strtotime($booking->checkin_date))}}</td>
                        <td>{{date('d M Y H:i:s', strtotime($booking->checkout_date))}}</td>
                        <td>{{$booking->status}}</td>
                        <td>
                            <a class="btn btn-success btn-circle btn-sm" href="{{route('booking.show',$booking->id)}}">
                                <i class="fas fa-eye"></i>
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <a type="button" href="{{route('tenant.index')}}" class="btn btn-secondary">Back</a>
        </div>

</div>
@endsection

@section('script')
{{-- datatable --}}
<script>
    $(document).ready(function() {
        $('#dataTable').DataTable();
    });
</script>
@endsection
