@extends('layouts.layout')

@section('content')
<div class="card shadow mb-4 col-lg-6 offset-lg-3">
  <div class="card-header py-3">
    <h5 class="m-0 font-weight-bold text-primary">Update Tenant</h5>
  </div>
  <div class="card-body">
    @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif
    <form action="{{route('tenant.update',$tenants->id)}}" method="POST" enctype="multipart/form-data">
        @csrf
        {{ method_field('PUT') }}
        <div class="form-group">
            <label for="tenant_name">Full Name</label>
            <input type="text" name="tenant_name" id="tenant_name" value="{{(old('tenant_name')) ? old('tenant_name') : $tenants->tenant_name}}" class="form-control" {{$errors->has('tenant_name') ? 'is-invalid' : ''}}>
            <p class="text-danger">{{$errors->first('tenant_name')}}</p>
        </div>
        <div class="form-group">
            <label for="email">Email</label>
            <p class="text-secondary"><small><i>** The email entered must be an active email</i></small></p>
            <input type="email" name="email" id="email" value="{{(old('email')) ? old('email') : $tenants->email}}" class="form-control" {{$errors->has('email') ? 'is-invalid' : ''}}>
            <p class="text-danger">{{$errors->first('email')}}</p>
        </div>
        <div class="form-group">
            <label for="type_IDcard">Type ID</label>
            <select class="form-control" name="type_IDcard" id="type_IDcard" {{$errors->has('type_IDcard') ? 'is-invalid' : ''}}>
                @if($tenants->type_IDcard == 'KTP')
                <option value="KTP" selected>KTP</option>
                <option value="Passport">Passport</option>
                <option value="SIM">SIM</option>
                @elseif($tenants->type_IDcard == 'Passport')
                <option value="KTP">KTP</option>
                <option value="Passport" selected>Passport</option>
                <option value="SIM">SIM</option>
                @elseif($tenants->type_IDcard == 'SIM')
                <option value="KTP">KTP</option>
                <option value="Passport">Passport</option>
                <option value="SIM" selected>SIM</option>
                @endif
            </select>
            <p class="text-danger">{{$errors->first('type_IDcard')}}</p>
        </div>
        <div class="form-group">
            <label for="IDcard_number">ID Number</label>
            <input type="text" min="0" name="IDcard_number" id="IDcard_number" value="{{(old('IDcard_number')) ? old('IDcard_number') : $tenants->IDcard_number}}" class="form-control" {{$errors->has('IDcard_number') ? 'is-invalid' : ''}}>
            <p class="text-danger" id="error-IDcard_number">{{$errors->first('IDcard_number')}}</p>
        </div>
        <div class="form-group">
            <label for="no_HP">Phone Number</label>
            <input type="number" min="0" name="no_HP" id="no_HP" placeholder="" value="{{(old('no_HP')) ? old('no_HP') : $tenants->no_HP}}" class="form-control" {{$errors->has('no_HP') ? 'is-invalid' : ''}}>
            <p class="text-danger">{{$errors->first('no_HP')}}</p>
        </div>
        <div class="form-group">
            <label for="address">Address</label>
            <input type="text" name="address" id="address" placeholder="" value="{{(old('address')) ? old('address') : $tenants->address}}" class="form-control" {{$errors->has('address') ? 'is-invalid' : ''}}>
            <p class="text-danger">{{$errors->first('address')}}</p>
        </div>
        <div class="form-group">
            <label for="status">Status</label>
            <select class="form-control" name="status" id="status" {{$errors->has('status') ? 'is-invalid' : ''}}>
                @if($tenants->status == 'active')
                <option value="active" selected>Active</option>
                <option value="inactive">inactive</option>
                @else
                <option value="active">Active</option>
                <option value="inactive" selected>Inactive</option>
                @endif
            </select>
            <p class="text-danger">{{$errors->first('status')}}</p>
        </div>

        <button type="submit" class="btn btn-primary">Update</button>
        <button type="reset" class="btn btn-danger" name="reset">Reset</button>
        <a type="button" href="{{route('tenant.index')}}" class="btn btn-secondary">Back</a>
        </form>
    </div>
</div>
@endsection
@section('script')
<script>
    $('#IDcard_number').on('keyup',function(){
        type = $('#type_IDcard').val();
        if(type == 'Passport'){
            var passportformat = /^[A-PR-WYa-pr-wy][1-9]\d\s?\d{4}[1-9]$/;
            if(this.value.match(passportformat)){
                $('#error-IDcard_number').html('');
                return true;
            }else{
                $('#error-IDcard_number').html('invalid passport..');
                return false;
            }
        }
    $('#error-IDcard_number').html('');
    })
</script>
@endsection
