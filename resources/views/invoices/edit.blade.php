@extends('layouts.layout')

@section('content')
<div class="col-xl-12">
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h5 class="m-0 font-weight-bold text-primary">Edit Invoice </h5>
        </div>
        <div class="card-body">
            <div class="row">
                {{-- booking --}}
                <div class="card" style="width: 10rem; margin: 2rem;">
                    <div class="card-body">
                        <i class="fas fa-book card-title"></i>
                        <h6 class="card-subtitle mb-2 text-muted" style="font-weight: bold; margin: 2px">Booking Date</h6>
                        <p class="card-text">{{date('d M Y H:i:s', strtotime($bookings->booking_date))}}</p>
                    </div>
                </div>
                <div class="card" style="width: 10rem; margin: 2rem;">
                    <div class="card-body">
                        <i class="fas fa-user card-title"></i>
                        <h6 class="card-subtitle mb-2 text-muted" style="font-weight: bold; margin: 2px">Tenant</h6>
                        @foreach ( $bookings->tenants as $tenant)
                        <p class="card-text">{{$tenant->tenant_name}}</p>
                        @endforeach
                    </div>
                </div>
                <div class="card" style="width: 10rem; margin: 2rem;">
                    <div class="card-body">
                        <i class="fas fa-bed card-title"></i>
                        <h6 class="card-subtitle mb-2 text-muted" style="font-weight: bold; margin: 2px">Room</h6>
                        @foreach ( $bookings->rooms as $room)
                        <p class="card-text">Type {{$room->types->type_name}} No {{$room->no_room}}</p>
                        @endforeach
                    </div>
                </div>
                <div class="card" style="width: 10rem; margin: 2rem;">
                    <div class="card-body">
                        <i class="fas fa-calendar card-title"></i>
                        <h6 class="card-subtitle mb-2 text-muted" style="font-weight: bold; margin: 2px">Check-in Date</h6>
                        <p class="card-text">{{date('d M Y H:i:s', strtotime($bookings->checkin_date))}}</p>
                    </div>
                </div>
                <div class="card" style="width: 10rem; margin: 2rem;">
                    <div class="card-body">
                        <i class="fas fa-calendar card-title"></i>
                        <h6 class="card-subtitle mb-2 text-muted" style="font-weight: bold; margin: 2px">Check-out Date</h6>
                        <p class="card-text">{{date('d M Y H:i:s', strtotime($bookings->checkout_date))}}</p>
                    </div>
                </div>
                <div class="card" style="width: 10rem; margin: 2rem;">
                    <div class="card-body">
                        <i class="fas fa-calendar card-title"></i>
                        <h6 class="card-subtitle mb-2 text-muted" style="font-weight: bold; margin: 2px">Status</h6>
                        <p class="card-text">{{$bookings->status}}</p>
                    </div>
                </div>
            </div>
                {{-- invoice --}}
                <div class="col-xl-12">
                    @if (session('success-invoice'))
                    <div class="alert alert-success alert-dismissible fade show">
                        {!! session('success-invoice') !!}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    @endif
                    @if (session('error-invoice'))
                    <div class="alert alert-danger alert-dismissible fade show">
                        {!! session('error') !!}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    @endif
                    <form method="POST" id="form" action="{{route('invoice.update',$invoices->id)}}">
                        @csrf
                        {{ method_field('PUT') }}
                        <div class="form-group">
                            <label for="booking_id">Booking ID</label>
                            <input type="text" name="booking_id" id="booking_id" class="form-control" value="{{$invoices->booking_id}}" {{$errors->has('booking_id') ? 'is-invalid' : ''}} disabled>
                            <p class="text-danger">{{$errors->first('booking_id')}}</p>
                        </div>

                        <div class="form-group">
                            <label for="invoice_date">Invoice date</label>
                            <input type="text" name="invoice_date" id="invoice_date" class="form-control" value="{{date('d F Y, h:i:s A')}}" {{$errors->has('invoice_date') ? 'is-invalid' : ''}} disabled>
                            <p class="text-danger">{{$errors->first('invoice_date')}}</p>
                        </div>
                        <div class="form-group">
                            <label for="subtotal_room">SubTotal Room</label>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Rp.</span>
                                </div>
                                <input type="number" min="0" name="subtotal_room" id="subtotal_room" class="form-control" value="{{$subtotal_room}}" {{$errors->has('subtotal_room') ? 'is-invalid' : ''}} disabled>
                            </div>
                            <p class="text-danger">{{$errors->first('subtotal_room')}}</p>
                        </div>
                        <div class="form-group">
                            <label for="discount">Discount</label>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Rp.</span>
                                </div>
                                <input type="number" min="0" name="discount" id="discount" class="form-control" value="{{$invoices->discount}}" {{$errors->has('discount') ? 'is-invalid' : ''}} onkeyup="total()">
                            </div>
                            <p class="text-danger">{{$errors->first('discount')}}</p>
                        </div>
                        <div class="form-group">
                            <label for="additional_cost">Additional Cost</label>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Rp.</span>
                                </div>
                                <input type="number" min="0" name="additional_cost" id="additional_cost" class="form-control" value="{{$invoices->additional_cost}}" {{$errors->has('additional_cost') ? 'is-invalid' : ''}} onkeyup="total()">
                            </div>
                            <p class="text-danger">{{$errors->first('additional_cost')}}</p>
                        </div>
                        <div class="form-group">
                            <label for="total_payment">Total Payment</label>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Rp.</span>
                                </div>
                                <input type="number" min="0" name="total_payment" id="total_payment" class="form-control" value="{{$total_payment}}" {{$errors->has('total_payment') ? 'is-invalid' : ''}} disabled>
                            </div>
                            <p class="text-danger">{{$errors->first('total_payment')}}</p>
                        </div>
                        <div class="form-group">
                            <label for="payment_method">Payment Method</label>
                            <select class="form-control" name="payment_method" id="payment_method" {{$errors->has('payment_method') ? 'is-invalid' : ''}}>
                                @if($invoices->payment_method == 'cash')
                                <option value="cash" selected>cash</option>
                                <option value="transfer">transfer</option>
                                @else
                                <option value="cash">cash</option>
                                <option value="transfer" selected>transfer</option>
                                @endif
                            </select>
                            <p class="text-danger">{{$errors->first('payment_method')}}</p>
                        </div>
                        <div class="form-group">
                            <label for="is_paid">Is Paid ?</label>
                            <select class="form-control" name="is_paid" id="is_paid" {{$errors->has('is_paid') ? 'is-invalid' : ''}} onChange="paid_action()">
                                @if($invoices->is_paid == 'paid')
                                <option value="paid" selected>paid</option>
                                <option value="unpaid">unpaid</option>
                                @else
                                <option value="paid">paid</option>
                                <option value="unpaid" selected>unpaid</option>
                                @endif
                            </select>
                            <p class="text-danger">{{$errors->first('is_paid')}}</p>
                        </div>



                        <button type="submit" class="btn btn-primary">Update</button>
                        <button type="reset" class="btn btn-danger" name="reset">Reset</button>
                        <a type="button" href="{{route('invoice.show',$invoices->id)}}" class="btn btn-secondary">Back</a>
                    </form>
                </div>


        </div>
    </div>
</div>
@endsection


<script>
    //hitung total payment otomatis ketika input discount dan additional_cost
    function total() {
        var subtotal_room = document.getElementById('subtotal_room').value;
        var additional_cost = document.getElementById('additional_cost').value;
        var discount = document.getElementById('discount').value;
        var total_payment = parseFloat(subtotal_room) + parseFloat(additional_cost) - parseFloat(discount);
        if (!isNaN(total_payment)) {
            document.getElementById('total_payment').value = total_payment;
        }
    }


</script>
