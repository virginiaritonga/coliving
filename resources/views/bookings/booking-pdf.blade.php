<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Booking Details</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <style>
        .invoice-box {
            position: fixed;
            max-width: 800px;
            margin: auto;
            padding: 10px;
            border: 1px solid #eee;
            box-shadow: 0 0 10px rgba(0, 0, 0, .15);
            font-size: 10px;
            /* line-height: 24px; */
            font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
            color: #555;
        }

        h3 {
            font-size: 20px;
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
        
        .invoice-box table tr.top table td.title {
            font-size: 45px;
            line-height: 45px;
            color: #333;
        }

        .invoice-box table tr.information table td {
            padding-bottom: 10px;
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
            padding-bottom: 10px;
        }

        .invoice-box table tr.item td {
            border-bottom: 1px solid #eee;
        }

        .invoice-box table tr.item.last td {
            border-bottom: none;
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
</head>

<body>
    <div class="invoice-box">
        <table cellpadding="0" cellspacing="0">
            <tr class="top">
                <td colspan="4">
                    <table>
                        <tr>
                            <td class="title">
                                <h3 style="color:mediumslateblue"> Safira Halim <br> Homestay</h3>
                            </td>
                            <td>
                                Booking #{{ $bookings->id }}<br>
                                Created at:<br> {{ $bookings->booking_date }}<br>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr class="information">
                <td colspan="3">
                    <table>
                        <tr>
                            <td>
                                <h4>Check-in:</h4>
                                <p>{{ $bookings->checkin_date }} </p>
                            </td>
                            <td style="text-align: left;">
                                <h4>Check-out:</h4>
                                <p>{{ $bookings->checkout_date }} </p>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr class="information">
                <td>
                <h4>Tenant Details</h4>
                </td>
            </tr>
            <tbody>
                <tr class="heading">
                    <td>Tenant Name</td>
                    <td>ID Card Type</td>
                    <td>ID Card Number</td>
                    <td>Phone Number</td>
                </tr>
                @foreach ($tenants as $tenant)
                <tr class="item">
                    <td>{{$tenant->tenant_name}}</td>
                    <td>{{$tenant->type_IDcard}}</td>
                    <td>{{$tenant->IDcard_number}}</td>
                    <td>{{$tenant->no_HP}}</td>
                </tr>
                @endforeach
            </tbody>
            <tr class="information">
                <td>
                <h4>Booking Details</h4>
                </td>
            </tr>
            <tbody>
                <tr class="heading">
                    <td>Room Number</td>
                    <td>Type</td>
                </tr>
                @foreach ($rooms as $room)
                <tr class="item">
                    <td>{{$room->no_room}}</td>
                    <td>{{$room->types->type_name}}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>

</html>