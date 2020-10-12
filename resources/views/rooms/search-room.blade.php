@extends('layouts.layout')

@section('content')
<div class="card shadow mb-4 ">
    <div class="card-header py-3">
        <h5 class="m-0 font-weight-bold text-primary">Search Available Room</h5>
    </div>
    <div class="card-body">
        @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show">
            {!! session('error') !!}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        @endif

        {{-- form search room --}}
        <form id="searchRoom">
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="checkin_date">Checkin Date</label>
                        <input class="form-control" type="datetime-local" name="checkin_date" id="checkin_date" value="{{ request()->input('checkin_date') }}" placeholder="" required >
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="checkout_date">Checkout Date</label>
                        <input class="form-control" type="datetime-local" name="checkout_date" id="checkout_date" value="{{ request()->input('checkout_date') }}" placeholder="" required>
                    </div>
                </div>
                <div class="col-md-4" style="padding-top: 2rem">
                    <button class="btn btn-success">
                        Search
                    </button>
                </div>
            </div>
        </form>

            {{-- HASIL --}}
            @if($rooms !== null)
            <hr />
            @if($rooms->count())
                <div class="table-responsive">
                    <table class=" table table-bordered table-striped table-hover datatable datatable-Event" id="dataTable">
                        <thead>
                            <tr>
                                <th>
                                    No Room
                                </th>
                                <th>
                                    Capacity
                                </th>
                                <th>
                                    Type
                                </th>
                                <th>
                                    Rent Price
                                </th>
                                <th>
                                    &nbsp;
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($rooms as $room)
                                <tr>
                                    <td class="room-name">
                                        {{ $room->no_room ?? '' }}
                                    </td>
                                    <td>
                                        {{ $room->types->capacity ?? '' }}
                                    </td>
                                    <td>
                                        {{ $room->types->type_name ?? '' }}
                                    </td>
                                    <td>
                                        Rp. {{ number_format($room->types->rent_price) ?? '' }}
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-sm btn-primary " data-toggle="modal" data-target="#showRoom"  data-room-id="{{ $room->id }}" >
                                        Show Detail
                                        </button>
                                    </td>

                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <p class="text-center">There are no rooms available at the time you have chosen</p>
            @endif
        @endif
        <hr>

    </div>
</div>

<div class="modal fade" tabindex="-1" role="dialog" id="showRoom">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Booking of a room</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="description"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script>
$('#dataTable').DataTable();
$('#showRoom').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget);
    var roomId = button.data('room-id');
    var modal = $(this);
    // modal.find('#room_id').val(roomId);
    modal.find('.modal-title').text('Description of a room ' + button.parents('tr').children('.room-name').text());

    $.ajax({
        type: "GET",
        dataType: "json",
        url: '{{ route('room.description') }}',
        data: {'room_id': roomId},
        success: function (data) {
            $('#description').html(data.description);
        },
        error: function(request, errorType, errorMsg) {
            console.log("there was an issue with ajax call: " + errorMsg);
        },
    });


});
</script>
@endsection
