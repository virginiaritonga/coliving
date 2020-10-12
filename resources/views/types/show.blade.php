@extends('layouts.layout')

@section('content')
<div class="card shadow mb-4 ">
    <div class="card-header py-3">
        <h5 class="m-0 font-weight-bold text-primary">Detail Type</h5>
    </div>
    <div class="card-body">
        @if (session('success'))
        <div class="alert alert-success">
            {!! session('success') !!}
        </div>
        @endif
        <div class="row no-gutters align-items-center table-responsive">
            <div class="col mr-2">
                <div class="col xl-4" style="padding-left: 20px;">
                    <h2>{{$types->type_name}} Room Type</h2>
                </div>
                <div class="row">
                    <div class="card" style="width: 10rem; margin: 2rem;">
                        <div class="card-body">
                            <i class="fas fa-user card-title"></i>
                            <h6 class="card-subtitle mb-2 text-muted" style="font-weight: bold; margin: 2px">Capacity</h6>
                            <p class="card-text">{{$types->capacity}} person(s)</p>
                        </div>
                    </div>
                    <div class="card" style="width: 10rem; margin: 2rem;">
                        <div class="card-body">
                            <i class="fas fa-credit-card card-title"></i>
                            <h6 class="card-subtitle mb-2 text-muted" style="font-weight: bold; margin: 2px">Rent Price <br> <small><i>( per days )</i></small></h6>
                            <p class="card-text">Rp. {{number_format($types->rent_price)}}</p>
                        </div>
                    </div>
                    <div class="card" style="width: 10rem; margin: 2rem;">
                        <div class="card-body">
                            <i class="fas fa-building card-title"></i>
                            <h6 class="card-subtitle mb-2 text-muted" style="font-weight: bold; margin: 2px">Total Rooms</h6>
                            <p class="card-text">{{$rooms->count()}}</p>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="card" style="width: 100%; margin: 2rem;">
                        <div class="card-body">
                            <i class="card-title"></i>
                            <h6 class="card-subtitle mb-2 text-muted" style="font-weight: bold; margin: 2px">Description</h6>
                            <p class="card-text">{{$types->description}}</p>
                        </div>
                    </div>
                </div>
                <div style="padding: 20px">
                    <h4 style="padding-bottom: 20px"> Details </h4>
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th scope="col">Room Number</th>
                                <th scope="col">Status</th>
                            </tr>
                        </thead>
                        <tbody id="myTable">
                            @foreach ($rooms as $room)
                            <tr>
                                <td>{{$room->no_room}}</td>
                                <td>{{$room->status}}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="form-group mt-4" style="padding: 20px">
                <a type="button" class="btn btn-primary " href="{{route('type.create-room',$types->id)}}">Add New Room</a>
                <a type="button" href="{{route('type.index')}}" class="btn btn-secondary">Back</a>
            </div>

        </div>

    </div>
</div>
@endsection

@section('script')
{{-- datatable --}}
<script>
    $(document).ready(function() {
        $('#dataTable').DataTable();
    });
</script>
@endsection
