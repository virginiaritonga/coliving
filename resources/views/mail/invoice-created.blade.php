@component('mail::message')
<style>
    .invoice-table td {
        border: 1px solid black;
        padding: 5px;
    }

    .total td {
        padding: 5px;
    }
</style>
# Thank You

<strong>This is your invoice</strong> <br>
Created at {{ \Carbon\Carbon::parse($invoice->invoice_date)->format('d M Y h:i:s A') }}
<table class="invoice-table" style="border-collapse: collapse; border: 1px solid black;">
    <tr>
        <td>Room Number</td>
        <td>Type</td>
        <td>Capacity</td>
        <td>Price</td>
        <td>Rent Days</td>
    </tr>
    @foreach ( $booking->rooms as $room )
    <tr>
        <td>{{$room->no_room}}</td>
        <td>{{$room->types->type_name}}</td>
        <td>{{$room->types->capacity}}</td>
        <td>Rp. {{number_format($room->types->rent_price)}}</td>
        <td>{{$rent_days}} day(s)</td>
    </tr>
    @endforeach
</table>
<br>
<table class="total">
    <tr>
        <td>Rent Days</td>
        <td>{{$rent_days}} day(s)</td>
    </tr>
    <tr>
        <td>Subtotal Room</td>
        <td>Rp {{number_format($subtotal_room)}} </td>
    </tr>
    <tr>
        <td>Discount</td>
        <td> - Rp {{number_format($invoice->discount)}} </td>
    </tr>
    <tr>
        <td>Additional Cost</td>
        <td>Rp {{number_format($invoice->additional_cost)}} </td>
    </tr>
    <tr>
        <td><strong>Total Payment</strong> </td>
        <td><strong>Rp {{number_format($total_payment)}}</strong> </td>
    </tr>
</table>
<br>
Best Regards,<br>
Safira Halim Homestay
@endcomponent
