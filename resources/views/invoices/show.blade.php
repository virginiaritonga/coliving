@extends('layouts.layout')

@section('content')
<style>
    .invoice-box {
        font-size: 16px;
        line-height: 24px;
        color: #555;
        overflow-x: auto;
    }

    .invoice-box table {
        width: 100%;
        line-height: inherit;
        text-align: left;
    }

    .invoice-box table td {
        padding: 5px;
        vertical-align: top;
    }

    .invoice-box table tr td:nth-child(2) {
        text-align: right;
    }

    .invoice-box table tr.top table td {
        padding-bottom: 20px;
    }

    .invoice-box table tr.top table td.title {
        font-size: 45px;
        line-height: 45px;
        color: #333;
    }

    .invoice-box table tr.information table td {
        padding-bottom: 40px;
    }

    .invoice-box table tr.heading td {
        background: #eee;
        border-bottom: 1px solid #ddd;
        font-weight: bold;
    }

    .invoice-box table tr th.heading {
        text-align: right;
        font-weight: bold;
    }

    .invoice-box table tr.details td {
        padding-bottom: 20px;
    }

    .invoice-box table tr.item td {
        border-bottom: 1px solid #eee;
    }

    .invoice-box table tr.item.last td {
        border-bottom: none;
    }

    .information td:nth-child(3) {
        text-align: right;
    }

    .invoice-box table tr.total td:nth-child(2) {
        border-top: 2px solid #eee;
        font-weight: bold;
    }

    @media only screen and (max-width: 600px) {
        .invoice-box table tr.top table td {
            width: 100%;
            display: block;
            text-align: center;
        }

        .invoice-box table tr.information table td {
            width: 100%;
            display: block;
            text-align: center;
        }
    }

    /** RTL **/
    .rtl {
        direction: rtl;
        font-family: 'Tahoma, 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif';
    }

    .rtl table {
        text-align: right;
    }

    .rtl table tr td:nth-child(2) {
        text-align: left;
    }
</style>
<div class="col-xl-12">
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h5 class="m-0 font-weight-bold text-primary">#{!! !empty($invoices) ? $invoices->invoice_number : '-' !!}</h5>
        </div>
        <br><br>
        <div class="card-body">
            <div class="invoice-box" style="padding-bottom: 20px">
                <table cellpadding="0" cellspacing="0">
                    <tr class="top">
                        <td colspan="7">
                            <table>
                                <tr>
                                    <td class="title">
                                        <h3 style="color:mediumslateblue"> Safira Halim <br> Homestay</h3>
                                    </td>
                                    <td>
                                        Invoice #{{ $invoices->id }}<br>
                                        Created at:<br> {{\Carbon\Carbon::parse($bookings->invoice_date)->format('d M Y h:i:s A')}}<br>
                                        Status: {!! !empty($invoices) ? $invoices->is_paid : '-' !!} <br>
                                        Payment Method: {!! !empty($invoices) ? $invoices->payment_method : '-' !!} <br>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <tr class="information">
                        <td colspan="7">
                            <table>
                                <tr>
                                    <td>
                                        <h4>Tenant Name: </h4>
                                        @foreach ($tenants as $tenant)
                                        {{$tenant->tenant_name}}<br>
                                        {{$tenant->no_HP}}<br>
                                        @endforeach
                                    </td>
                                    <td>
                                        <h4>Booking Date:</h4>
                                        <p>{{\Carbon\Carbon::parse($bookings->booking_date)->format('d M Y h:i:s A')}}</p>
                                        <p>Checkin: {{\Carbon\Carbon::parse($bookings->checkin_date)->format('d M Y h:i:s A')}} → Checkout: {{\Carbon\Carbon::parse($bookings->checkout_date)->format('d M Y h:i:s A')}} </p>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <tbody>
                        <tr class="heading">
                            <td>Room Number</td>
                            <td></td>
                            <td>Type</td>
                            <td>Capacity</td>
                            <td>Price</td>
                            <td>Rent Days</td>
                            <td>Subtotal</td>
                        </tr>
                        @foreach ($rooms as $room)
                        <tr class="item">
                            <td>{{$room->no_room}}</td>
                            <td></td>
                            <td>{{$room->types->type_name}}</td>
                            <td>{{$room->types->capacity}}</td>
                            <td>Rp. {{number_format($room->types->rent_price)}}</td>
                            <td>{{$rent_days}} days</td>
                            <td>Rp. {{number_format($room->types->rent_price * $rent_days)}}</td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <th colspan="6" class="heading">Sub Total Room</th>
                            <td>Rp. {{number_format($subtotal_room)}}</td>
                        </tr>
                        <tr>
                            <th colspan="6" class="heading">Discount</th>
                            <td style="color: #5cb85c">-Rp. {{number_format($invoices->discount)}}</td>
                        </tr>
                        <tr>
                            <th colspan="6" class="heading">Additional Cost</th>
                            <td>Rp. {{number_format($invoices->additional_cost)}}</td>
                        </tr>
                        <tr>
                            <th colspan="6" class="heading">Total</th>
                            <td>Rp. {{number_format($total_payment)}}</td>
                        </tr>
                    </tfoot>
                </table>
            </div>

            <a href="{{route('invoice.print',$invoices->id)}}" class="btn btn-primary btn-icon-split">
                <span class="icon text-white-50">
                    <i class="fas fa-print"></i>
                </span>
                <span class="text">Print Invoice</span>
            </a>
            <a type="button" href="{{route('invoice.edit',$invoices->id)}}" class="btn btn-warning">Edit Invoice</a>
            <button type="button" id="sendmail" data-invoice-id="{{$invoices->id}}" class="btn btn-success" style="color: #fff">Send Invoice To Tenant Email</button>
            <a type="button" href="{{action('BookingController@index')}}" class="btn btn-secondary">Back to List Booking</a>

            @if(empty($invoices) )
            <a href="{{route('invoice.create',$bookings->id)}}" class="btn btn-primary btn-icon-split">
                <span class="icon text-white-50">
                    <i class="fas fa-bars"></i>
                </span>
                <span class="text">Create Invoice</span>
            </a>
            <a type="button" href="{{action('BookingController@index')}}" class="btn btn-secondary">Back to List Booking</a>
            <a type="button" href="{{route('invoice.edit',$invoices->id)}}" class="btn btn-warning">Edit Invoice</a>
            @endif
        </div>
    </div>
</div>
@endsection

@section('script')
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script>
$(document).ready(function(){
    $('button#sendmail ').on('click',function(event){
        var button = $(event.relatedTarget);
        var invoiceId = $(this).data('invoice-id');
        $('button#sendmail').html('Sending...');
        $.ajax({
            type: "GET",
            dataType: "json",
            url: '{{ route('mail-invoice') }}',
            data: {'invoice_id': invoiceId},
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
