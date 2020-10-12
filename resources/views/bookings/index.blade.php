@extends('layouts.layout')

@section('content')
<div class="col-xl-12">
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">BOOKINGS LIST</h6>
        </div>
        <div class="card-body">
            @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show">
                {!! session('success') !!}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            @elseif (session('error'))
            <div class="alert alert-danger alert-dismissible fade show">
                {!! session('error') !!}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            @endif
            <a href="{{route('booking.create')}}" class="btn btn-primary btn-icon-split" style="margin-bottom: 5px;">
                <span class="icon text-white-50">
                    <i class="fas fa-plus"></i>
                </span>
                <span class="text">New Booking</span>
            </a>
            <div class="row no-gutters align-items-center">
                <div class="col mr-2" style="overflow-x:auto;">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th scope="col">ID</th>
                                <th scope="col">Booking Date</th>
                                <th scope="col">Name</th>
                                <th scope="col">Room</th>
                                <th scope="col">Check-in Date</th>
                                <th scope="col">Check-out Date</th>
                                <th scope="col">Status</th>
                                <th scope="col">Change Status</th>
                                <th scope="col">Invoice</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($bookings as $booking)
                            <tr data-id="{{$booking->id}}">
                                <th scope="row">{{$booking->id}}</th>
                                <td>{{date('d M Y', strtotime($booking->booking_date))}}</td>
                                <td>
                                    @foreach ( $booking->tenants as $tenant)
                                    <span>{{$tenant->tenant_name}}</span><br>
                                    @endforeach
                                </td>
                                <td>
                                    @foreach ( $booking->rooms as $room)
                                    <span>{{$room->types->type_name}} No. {{$room->no_room}}</span><br>
                                    @endforeach
                                </td>
                                <td>{{date('d M Y', strtotime($booking->checkin_date))}}</td>
                                <td>{{date('d M Y', strtotime($booking->checkout_date))}}</td>
                                <td id="stats">{{$booking->status}}</td>
                                <td>
                                    <select class="form-control" name="status" id="status" data-id="{{ $booking->id }}" {{ $booking->status == 'checked-out' ? 'disabled' : '' }}>
                                        @if($booking->status == 'booked')
                                        <option value="booked" selected>booked</option>
                                        <option value="checked-in">checkin</option>
                                        <option value="checked-out">checkout</option>
                                        @elseif ($booking->status == 'checked-in')
                                        <option value="booked">booked</option>
                                        <option value="checked-in" selected>checkin</option>
                                        <option value="checked-out">checkout</option>
                                        @else
                                        <option value="booked">booked</option>
                                        <option value="checked-in">checkin</option>
                                        <option value="checked-out" selected>checkout</option>
                                        @endif
                                    </select>
                                </td>
                                <td>
                                    @if(!empty($booking->invoices->id))
                                    <a class="btn btn-primary btn-circle btn-sm" href="{{route('invoice.show',$booking->invoices->id)}}"><i class="fas fa-print"></i></a>
                                    @else
                                    <a class="btn btn-primary btn-circle btn-sm" href="{{route('invoice.create',$booking->id)}}"><i class="fas fa-plus"></i></a>
                                    @endif
                                </td>
                                <td>
                                    <a class="btn btn-success btn-circle btn-sm" href="{{route('booking.show',$booking->id)}}">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="#" class="btn btn-danger btn-circle btn-sm" data-toggle="modal" data-target="#deleteModal" data-id="{{$booking->id}}">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                    @if($booking->status == 'booked')
                                    <a class="btn btn-warning btn-circle btn-sm" id="editBooking" href="{{route('booking.edit',$booking->id)}}"><i class="fas fa-edit"></i></a>
                                    @endif
                                </td>

                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div id="deleteModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Delete Booking ?</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <p>Are you sure delete this booking?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <form action="#" method="POST" id="deleteForm">
                    @csrf
                    {{ method_field('DELETE') }}
                    <button type="submit" class="btn btn-danger" id="delete-btn">Delete</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script src="{{asset('datatables/dataTables.buttons.min.js')}}"></script>
<script src="{{asset('datatables/buttons.flash.min.js')}}"></script>
<script src="{{asset('datatables/jszip.min.js')}}"></script>
<script src="{{asset('datatables/pdfmake.min.js')}}"></script>
<script src="{{asset('datatables/vfs_fonts.js')}}"></script>
<script src="{{asset('datatables/buttons.html5.min.js')}}"></script>
<script src="{{asset('datatables/buttons.print.min.js')}}"></script>
{{-- <script src="{{asset('js/demo/datatables-demo.js')}}"></script> --}}
<!--Toaster -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script>
    $('#dataTable').DataTable( {
        dom: 'lBfrtip',
        buttons: [
            {
                extend: 'excel',
                exportOptions: {
                    columns: [ 0, 1, 2, 3, 4, 5, 6 ]
                }
            },
            {
                extend: 'pdf',
                exportOptions: {
                    columns: [ 0, 1, 2, 3, 4, 5, 6 ]
                }
            },
            {
                extend: 'print',
                exportOptions: {
                    columns: [ 0, 1, 2, 3, 4, 5, 6 ]
                }
            },
        ]
    } );

    $('#deleteModal').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget); // Button that triggered the modal
        var id = button.data('id'); // Extract info from data-* attributes
        // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
        var modal = $(this);
        var form = document.getElementById("deleteForm");
        var url = '{{ action("BookingController@destroy", ":id") }}';
        url = url.replace(':id', id);
        form.action = url;
    })

    $(document).ready(function() {
        $('.form-control').change(function() {
            let status = $(this).val();
            let bookingId = $(this).data('id');
            $.ajax({
                type: "GET",
                dataType: "json",
                url: '{{ route('booking.update.status') }}',
                data: {
                    'status': status,
                    'booking_id': bookingId
                },
                success: function(data) {
                    toastr.options.closeButton = true;
                    toastr.options.closeMethod = 'fadeOut';
                    toastr.options.closeDuration = 100;
                    toastr.success(data.message);
                    $("table tr[data-id='"+bookingId+"'] #stats").html(data.status);
                    if(data.status !== 'booked'){
                        $("table tr[data-id='"+bookingId+"'] #editBooking").hide();
                    }
                    location.reload(true);
                },
                error: function(request, errorType, errorMsg) {
                    console.log("there was an issue with ajax call: " + errorMsg);
                },
            });
            //after checked-out can't change status booking
            if(status == 'checked-out'){
                $(".form-control[data-id='"+bookingId+"']").prop('disabled', true);
            }

        });

    });
</script>
@endsection
