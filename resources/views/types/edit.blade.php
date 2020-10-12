@extends('layouts.layout')

@section('content')
<div class="row">
    <div class="col"></div>
    <div class="col-lg-6">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h5 class="m-0 font-weight-bold text-primary">Update Type</h5>
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
                <form action="{{route('type.update',$types->id)}}" method="POST">
                    @csrf
                    {{ method_field('PUT') }}
                    <div class="form-group">
                        <label for="type_name">Type Name</label>
                        <input type="text" name="type_name" id="type_name" value="{{(old('type_name')) ? old('type_name') : $types->type_name}}" class="form-control" {{$errors->has('type_name') ? 'is-invalid' : ''}}>
                        <p class="text-danger">{{$errors->first('type_name')}}</p>
                    </div>
                    <div class="form-group">
                        <label for="capacity">Capacity</label>
                        <input type="number" min="0" name="capacity" id="capacity"  value="{{(old('capacity')) ? old('capacity') : $types->capacity}}" class="form-control" {{$errors->has('capacity') ? 'is-invalid' : ''}}>
                        <p class="text-danger">{{$errors->first('capacity')}}</p>
                    </div>
                    <div class="form-group">
                        <label for="rent_price">Rent Price <small><i>( per days )</i></small></label>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">Rp.</span>
                            </div>
                            <input type="number" min="0" name="rent_price" id="rent_price" placeholder="Rp. -"  value="{{(old('rent_price')) ? old('rent_price') : $types->rent_price}}" class="form-control" {{$errors->has('rent_price') ? 'is-invalid' : ''}}>
                            <p class="text-danger">{{$errors->first('rent_price')}}</p>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="description">Description</label>
                        <textarea style="min-height: 10em; max-height: 50vh; width: 100%;" name="description" id="description"  class="form-control" {{$errors->has('description') ? 'is-invalid' : ''}}>{{(old('description')) ? old('description') : $types->description}} </textarea>
                        <p class="text-danger">{{$errors->first('description')}}</p>
                    </div>
                    <button type="submit" class="btn btn-primary">Update</button>
                    <a type="button" href="{{route('type.index')}}" class="btn btn-secondary">Back</a>
                </form>
            </div>
        </div>
    </div>
    <div class="col"></div>
</div>
@endsection
