@extends('layouts.layout')

@section('content')
<div class="row">
    <div class="col"></div>
    <div class="col-lg-6">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h5 class="m-0 font-weight-bold text-primary">Add Tenant</h5>
            </div>
            <div class="card-body">
                @if (session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
                @endif
                <form action="{{route('tenant.store')}}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="tenant_name">Full Name</label>
                        <input type="text" name="tenant_name" id="tenant_name" value="{{ old('tenant_name') }}" class="form-control" {{$errors->has('tenant_name') ? 'is-invalid' : ''}}>
                        <p class="text-danger">{{$errors->first('tenant_name')}}</p>
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <p class="text-secondary"><small><i>** The email entered must be an active email</i></small></p>
                        <input type="email" name="email" id="email" value="{{ old('email') }}" class="form-control" {{$errors->has('email') ? 'is-invalid' : ''}}>
                        <p class="text-danger">{{$errors->first('email')}}</p>
                    </div>
                    <div class="form-group">
                        <label for="type_IDcard">Type ID</label>
                        <select class="form-control" name="type_IDcard" id="type_IDcard" {{$errors->has('type_IDcard') ? 'is-invalid' : ''}}>
                            <option value=""></option>
                            <option value="KTP" {{old('type_IDcard') == 'KTP' ? 'selected' : ''}}>KTP</option>
                            <option value="Passport" {{old('type_IDcard') == 'Passport' ? 'selected' : ''}}>Passport</option>
                            <option value="SIM" {{old('type_IDcard') == 'SIM' ? 'selected' : ''}}>SIM</option>
                        </select>
                        <p class="text-danger">{{$errors->first('type_IDcard')}}</p>
                    </div>
                    <div class="form-group">
                        <label for="IDcard_number">ID Number</label>
                        <input type="text" min="0" name="IDcard_number" id="IDcard_number" value="{{ old('IDcard_number') }}" class="form-control" {{$errors->has('IDcard_number') ? 'is-invalid' : ''}}>
                        <p class="text-danger" id="error-IDcard_number">{{$errors->first('IDcard_number')}}</p>
                    </div>
                    <div class="form-group">
                        <label for="no_HP">Phone Number</label>
                        <input type="number" min="0" name="no_HP" id="no_HP" placeholder=""  value="{{ old('no_HP') }}" class="form-control" {{$errors->has('no_HP') ? 'is-invalid' : ''}}>
                        <p class="text-danger">{{$errors->first('no_HP')}}</p>
                    </div>
                    <div class="form-group">
                        <label for="address">Address</label>
                        <input type="text" name="address" id="address" placeholder=""  class="form-control "  value="{{ old('address') }}" {{$errors->has('address') ? 'is-invalid' : ''}}>
                        <p class="text-danger">{{$errors->first('address')}}</p>
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                    <button type="reset" class="btn btn-danger" name="reset">Reset</button>
                    <a type="button" href="{{route('tenant.index')}}" class="btn btn-secondary">Back</a>
                </form>
            </div>
        </div>
    </div>
    <div class="col"></div>
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
