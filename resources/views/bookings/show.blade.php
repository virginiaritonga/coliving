@extends('layouts.layout')

@section('content')
<div class="row">
    <div class="col"></div>
    <div class="col-lg-6">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h5 class="m-0 font-weight-bold text-primary">Booking #{{$bookings->id}}</h5>
            </div>
            <div class="card-body">
                <p><strong>Booking Date: </strong><br> <span class="text">{{date('d M Y H:i:s', strtotime($bookings->booking_date))}}</span></p>
                <p><strong>Tenant Name: </strong><br>
                    <ol>
                        @foreach ($bookings->tenants as $tenant)
                        <li>{{$tenant->tenant_name}}</li>
                        @endforeach
                    </ol>
                </p>
                <p><strong>Detail Room: </strong><br> <span class="text">
                        <ol>
                            @foreach ($bookings->rooms as $room)
                            <li>Room: {{$room->no_room}}, Type: {{$room->types->type_name}}</li>
                            @endforeach
                        </ol>
                    </span></p>
                <p><strong>Checkin: </strong><br> <span class="text">{{date('d M Y H:i:s', strtotime($bookings->checkin_date))}}</span></p>
                <p><strong>Checkout: </strong><br> <span class="text">{{date('d M Y H:i:s', strtotime($bookings->checkout_date))}}</span></p>

                <button type="button" id="sendmail" data-booking-id="{{$bookings->id}}" class="btn btn-success" style="color: #fff;">Send to Tenant Email</button>
                @if(!empty($bookings->invoices->id))
                <a class="btn btn-primary" href="{{route('invoice.show',$bookings->invoices->id)}}"><i class="fas fa-eye"></i></a>
                @else
                <a class="btn btn-primary" href="{{route('invoice.create',$bookings->id)}}"><i class="fas fa-plus"></i></a>
                @endif
                <a href="{{route('booking.print',$bookings->id)}}" class="btn btn-primary btn-icon-split">
                    <span class="icon text-white-50">
                        <i class="fas fa-print"></i>
                    </span>
                </a>
                <a type="button" href="{{ url()->previous() }}" class="btn btn-secondary">Back</a>
            </div>
        </div>
    </div>
    <div class="col"></div>
</div>
@endsection

@section('script')
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script>
$(document).ready(function(){
    $('button#sendmail ').on('click',function(event){
        var button = $(event.relatedTarget);
        var bookingId = $(this).data('booking-id');
        $('button#sendmail').html('Sending...');
        $.ajax({
            type: "GET",
            dataType: "json",
            url: '{{ route('mail-booking') }}',
            data: {'booking_id': bookingId},
            success: function (data) {
                $('button#sendmail').html('Done!!');
                $('button#sendmail').prop('disabled', true);
                toastr.options.closeButton = true;
                toastr.options.closeMethod = 'fadeOut';
                toastr.options.closeDuration = 100;
                toastr.success(data.message);
            },
            error: function(request, errorType, errorMsg) {
                console.log("there was an issue with ajax call: " + errorMsg);
            },
        });
    });
});
</script>
@endsection
