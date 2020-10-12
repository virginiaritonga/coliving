@extends('layouts.layout')

@section('content')
<div class="col-xl-12">
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">ROOM LISTS</h6>
        </div>
        <div class="card-body">
            @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show">
                {!! session('success') !!}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            @endif
            <a href="{{route('room.create')}}" class="btn btn-primary btn-icon-split" style="margin-bottom: 5px;">
                <span class="icon text-white-50">
                    <i class="fas fa-plus"></i>
                </span>
                <span class="text">Add Room</span>
            </a>
            <br>
            <div class="row no-gutters align-items-center table-responsive">
                <div class="col mr-2" style="overflow-x:auto;">
                    {{-- <div class="text-s font-weight-bold text-dark text-uppercase mb-1">Room Details</div> --}}
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th scope="col">No</th>
                                <th scope="col">Room Number</th>
                                <th scope="col">Type</th>
                                <th scope="col">Capacity</th>
                                <th scope="col">Rent</th>
                                <th scope="col">Status</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody id="myTable">
                            @php $no=0; @endphp
                            @foreach ($rooms as $room)
                            @php $no++; @endphp
                            <tr>
                                <th scope="row">{{$no}}</th>
                                <td>{{$room->no_room}}</td>
                                <td>{{$room->types->type_name}}</td>
                                <td>{{$room->types->capacity}}</td>
                                <td>Rp. {{number_format($room->types->rent_price)}}</td>
                                @if ($room->status == 'available')
                                <td class="text-success">{{$room->status}}</td>
                                @elseif($room->status == 'booked')
                                <td class="text-warning">{{$room->status}}</td>
                                @else
                                <td class="text-danger">{{$room->status}}</td>
                                @endif
                                <td>
                                    <a class="btn btn-success btn-circle btn-sm" href="{{route('room.show',$room->id)}}">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a class="btn btn-warning btn-circle btn-sm" href="{{route('room.edit',$room->id)}}">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <a href="#" class="btn btn-danger btn-circle btn-sm" data-toggle="modal" data-target="#deleteModal" data-id="{{$room->id}}">
                                        <i class="fas fa-trash"></i>
                                    </a>
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
            <h5 class="modal-title">Delete Room</h5>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
            <p>Are you sure delete this room ?</p>
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
{{-- datatable --}}
<script src="{{asset('datatables/dataTables.buttons.min.js')}}"></script>
<script src="{{asset('datatables/buttons.flash.min.js')}}"></script>
<script src="{{asset('datatables/jszip.min.js')}}"></script>
<script src="{{asset('datatables/pdfmake.min.js')}}"></script>
<script src="{{asset('datatables/vfs_fonts.js')}}"></script>
<script src="{{asset('datatables/buttons.html5.min.js')}}"></script>
<script src="{{asset('datatables/buttons.print.min.js')}}"></script>
<script src="{{asset('js/demo/datatables-demo.js')}}"></script>
<script>

    $('#deleteModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget); // Button that triggered the modal
        var id = button.data('id'); // Extract info from data-* attributes
        // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
        var modal = $(this);
        var form = document.getElementById("deleteForm");
        var url = '{{ action("RoomController@destroy", ":id") }}';
        url = url.replace(':id', id);
        form.action = url;
    })

</script>
@endsection
