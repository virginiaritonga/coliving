<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Invoice</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <style>
        .invoice-box {
            position: fixed;
            width: 100%;
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

        .invoice-box table tr.top table td {
            padding-bottom: 10px;
        }

        .invoice-box table tr.top table td.title {
            font-size: 45px;
            line-height: 45px;
            color: #333;
        }

        .invoice-box table tr.information table td {
            padding-bottom: 20px;
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
                <td colspan="5">
                    <table>
                        <tr>
                            <td class="title">
                                <h3 style="color:mediumslateblue"> Safira Halim <br> Homestay</h3>
                            </td>
                            <td>
                                Invoice #{{ $invoices->id }}<br>
                                Created at:<br> {{ $invoices->invoice_date }}<br>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>

            <tr class="information">
                <td colspan="2">
                    <table>
                        <tr>
                            <td>
                                <h4>Tenant Name: </h4>
                                @foreach ($tenants as $tenant)
                                <p>{{$tenant->tenant_name}}</p>
                                @endforeach
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>

            <tbody>
                <tr class="heading">
                    <td>Room Number</td>
                    <td>Type</td>
                    <td>Price</td>
                    <td>Rent Days</td>
                    <td>Subtotal</td>
                </tr>
                @foreach ($rooms as $room)
                <tr class="item">
                    <td>{{$room->no_room}}</td>
                    <td>{{$room->types->type_name}}</td>
                    <td>Rp. {{number_format($room->types->rent_price)}}</td>
                    <td>{{$rent_days}} days</td>
                    <td>Rp. {{number_format($room->types->rent_price * $rent_days)}}</td>
                </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="4" class="heading">Sub Total Room</th>
                    <td>Rp. {{number_format($subtotal_room)}}</td>
                </tr>
                <tr>
                    <th colspan="4" class="heading">Discount</th>
                    <td style="color: #5cb85c">-Rp. {{number_format($invoices->discount)}}</td>
                </tr>
                <tr>
                    <th colspan="4" class="heading">Additional Cost</th>
                    <td>Rp. {{number_format($invoices->additional_cost)}}</td>
                </tr>
                <tr>
                    <th colspan="4" class="heading">Total</th>
                    <td>Rp. {{number_format($total_payment)}}</td>
                </tr>
            </tfoot>
        </table>
    </div>
</body>

</html>