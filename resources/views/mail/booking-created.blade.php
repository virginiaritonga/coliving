@component('mail::message')
<style>
    .tenant-table td {
        border: 1px solid black;
        padding: 5px;
    }
</style>
# Thank you for your reservation at Safira Halim Homestay

If you require any further information, please feel free to contact us at admin@synapsis.id. <br>

<strong>Your reservation details: </strong> <br>
Tenant Details: <br>

<table class="tenant-table" style="border-collapse: collapse; border: 1px solid black;">
    <tr>
        <td>Tenant Name</td>
        <td>ID Card Type</td>
        <td>ID Card Number</td>
        <td>Phone Number</td>
    </tr>
    @foreach ( $booking->tenants as $tenant )
    <tr>
        <td>{{$tenant->tenant_name}}</td>
        <td>{{$tenant->type_IDcard}}</td>
        <td>{{$tenant->IDcard_number}}</td>
        <td>{{$tenant->no_HP}}</td>
    </tr>
    @endforeach
</table>
<br>
Booking Details <br>
Booking ID {{ $booking->id }} <br>
Booking Date: {{ \Carbon\Carbon::parse($booking->booking_date)->format('d M Y h:i:s A') }} <br>
Checkin Date: {{ \Carbon\Carbon::parse($booking->checkin_date)->format('d M Y h:i:s A') }} <br>
Checkout Date: {{\Carbon\Carbon::parse($booking->checkout_date)->format('d M Y h:i:s A') }} <br>
Room : <br>
<ol>
    @foreach ( $booking->rooms as $room )
    <li>Room No {{$room->no_room}} Type {{$room->types->type_name}}</li>
    @endforeach
</ol>
<br>
<i><strong>Note:</strong> Show this booking confirmation when checking-in</i>
<br><br>
Best Regards,<br>
Safira Halim Homestay
@endcomponent
