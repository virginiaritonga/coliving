@extends('layouts.layout')

@section('content')
<div class="card shadow mb-4 ">
    <div class="card-header py-3">
        <h5 class="m-0 font-weight-bold text-primary">Detail Room</h5>
    </div>
    <div class="card-body">

        @csrf
        <div class="row no-gutters align-items-center table-responsive">
            <div class="col mr-2">
                <div class="col xl-4" style="padding-left: 20px;">
                    <h2>Room Number {{$rooms->no_room}}</h2>
                </div>
                <div class="row">
                    <div class="card" style="width: 10rem; margin: 2rem;">
                        <div class="card-body">
                            <i class="fas fa-th-list card-title"></i>
                            <h6 class="card-subtitle mb-2 text-muted" style="font-weight: bold; margin: 2px">Type</h6>
                            <p class="card-text">{{$rooms->types->type_name}}</p>
                        </div>
                    </div>
                    <div class="card" style="width: 10rem; margin: 2rem;">
                        <div class="card-body">
                            <i class="fas fa-info card-title"></i>
                            <h6 class="card-subtitle mb-2 text-muted" style="font-weight: bold; margin: 2px">Status</h6>
                            @if ($rooms->status == 'available')
                            <p class=" card-text text-success">{{$rooms->status}}</p>
                            @elseif($rooms->status == 'booked')
                            <p class="card-text text-warning">{{$rooms->status}}</p>
                            @else
                            <p class="card-text text-danger">{{$rooms->status}}</p>
                            @endif
                        </div>
                    </div>
                </div>
                <div style="padding: 20px">
                    <h4 style="padding-bottom: 20px"> History Booking </h4>
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th scope="col">Booking ID</th>
                                <th scope="col">Booking Date</th>
                                <th scope="col">Tenant</th>
                                <th scope="col">Checked - in</th>
                                <th scope="col">Checked - Out</th>
                                <th scope="col">Status</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody id="myTable">
                            @foreach ($rooms->bookings as $booking)
                            <tr>
                                <td>{{$booking->id}}</td>
                                <td>{{date('d M Y H:i:s', strtotime($booking->booking_date))}}</td>
                                <td>
                                    @foreach ($booking->tenants as $tenant)
                                        <span><a href="{{route('tenant.show', $tenant->id)}}">{{$tenant->tenant_name}}</a></span><br>
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
                    <a type="button" href="{{route('room.index')}}" class="btn btn-secondary">Back</a>
                </div>
            </div>
        </div>
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
