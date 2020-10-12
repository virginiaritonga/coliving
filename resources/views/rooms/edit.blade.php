@extends('layouts.layout')

@section('content')
<div class="row">
    <div class="col"></div>
    <div class="col-lg-6">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h5 class="m-0 font-weight-bold text-primary">Update Room</h5>
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
                <form method="POST" action="{{route('room.update',$rooms->id)}}">
                    @csrf
                    {{ method_field('PUT') }}
                    <div class="form-group">
                        <label for="no_room">Room Number</label>
                        <input type="text" name="no_room" id="no_room" class="form-control" value="{{$rooms->no_room}}" {{$errors->has('no_room') ? 'is-invalid' : ''}}>
                        <p class="text-danger">{{$errors->first('no_room')}}</p>
                    </div>
                    <div class="form-group">
                        <label for="type_id">Type</label>
                        <select class="form-control" name="type_id" id="type" value="" {{$errors->has('type_id') ? 'is-invalid' : ''}}>
                            @foreach ($types as $type)
                            @if($type->id == $rooms->type_id)
                            <option value="{{$type->id}}" selected>{{$type->type_name}}</option>
                            @else
                            <option value="{{$type->id}}">{{$type->type_name}}</option>
                            @endif
                            @endforeach
                        </select>
                        <p class="text-danger">{{$errors->first('type_id')}}</p>
                    </div>
                    <div class="form-group">
                        <label for="status">Status</label>
                        <select class="form-control" name="status" id="status" {{$errors->has('status') ? 'is-invalid' : ''}}>
                            @if($rooms->status == 'available')
                            <option value="available" selected>Available</option>
                            <option value="booked">Booked</option>
                            <option value="maintenance">Maintenance</option>
                            @elseif($rooms->status == 'booked')
                            <option value="available">Available</option>
                            <option value="booked" selected>Booked</option>
                            <option value="maintenance">Maintenance</option>
                            @elseif($rooms->status == 'maintenance')
                            <option value="available">Available</option>
                            <option value="booked">Booked</option>
                            <option value="maintenance" selected>Maintenance</option>
                            @endif
                        </select>
                        <p class="text-danger">{{$errors->first('status')}}</p>
                    </div>
                    <button type="submit" class="btn btn-primary">Update Room</button>
                    <button type="reset" class="btn btn-danger" name="reset">Reset</button>
                    <a type="button" href="{{route('room.index')}}" class="btn btn-secondary">Back</a>
                </form>
            </div>
        </div>
    </div>
    <div class="col"></div>
</div>
@endsection
