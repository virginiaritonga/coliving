@extends('layouts.layout')

@section('content')
<div class="row">
    <div class="col"></div>
    <div class="col-lg-6">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h5 class="m-0 font-weight-bold text-primary">Add Room</h5>
            </div>
            <div class="card-body">
                @if (session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
                @endif
                <form method="POST" action="{{route('room.store')}}">
                    @csrf
                    <div class="form-group">
                        <label for="no_room">Room Number</label>
                        <input type="text" name="no_room" id="no_room" class="form-control" value="" {{$errors->has('no_room') ? 'is-invalid' : ''}}>
                        <p class="text-danger">{{$errors->first('no_room')}}</p>
                    </div>
                    <div class="form-group">
                        <label for="type_id">Type</label>
                        <select class="form-control" name="type_id" id="type_id" {{$errors->has('type_id') ? 'is-invalid' : ''}}>
                            @foreach ($types as $type)
                            <option value="{{$type->id}}">{{$type->type_name}}</option>
                            @endforeach
                        </select>
                        <p class="text-danger">{{$errors->first('type_id')}}</p>
                    </div>
                    <div class="form-group">
                        <label for="status">Status</label>
                        <select class="form-control" name="status" id="status" {{$errors->has('status') ? 'is-invalid' : ''}}>
                            <option value="available">Available</option>
                            <option value="booked">Booked</option>
                            <option value="maintenance">Maintenance</option>
                        </select>
                        <p class="text-danger">{{$errors->first('status')}}</p>
                    </div>
                    <button type="submit" class="btn btn-primary">Add Room</button>
                    <button type="reset" class="btn btn-danger" name="reset">Reset</button>
                    <a type="button" href="{{route('room.index')}}" class="btn btn-secondary">Back</a>
                </form>
            </div>
        </div>
    </div>
    <div class="col"></div>
</div>
@endsection
