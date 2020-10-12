@extends('layouts.layout')

@section('content')
<div class="card shadow mb-4 col-lg-6 offset-lg-3">
    <div class="card-header py-3">
    <h5 class="m-0 font-weight-bold text-primary">Add New Room @ Type {{$types->type_name}}</h5>
    </div>
    <div class="card-body">
        @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
        @endif
    <form method="POST" action="{{route('type.store-room',$types->id)}}">
        @csrf
        <div class="form-group">
            <label for="no_room">Room Number</label>
            <input type="text" name="no_room" id="no_room" class="form-control" value="{{old('no_room')}}" {{$errors->has('no_room') ? 'is-invalid' : ''}}>
            <p class="text-danger">{{$errors->first('no_room')}}</p>
        </div>
        <div class="form-group">
            <select class="form-control" name="type_id" id="type" hidden  {{$errors->has('type_id') ? 'is-invalid' : ''}}>
                <option value="{{$types->id}}">{{$types->type_name}}</option>
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
        <a type="button" href="{{route('type.show',$types->id)}}" class="btn btn-secondary">Back</a>
    </form>
    </div>
</div>
@endsection
