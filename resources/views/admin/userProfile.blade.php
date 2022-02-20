@extends('admin.master')
@section('content')
<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-header">
                <h5>Update Profile</h5>
                <hr>
                <span><!-- lorem ipsum dolor sit amet, consectetur adipisicing elit --></span>
                <div class="card-header-right">
                    <ul class="list-unstyled card-option">
                        <li><i class="feather icon-maximize full-card"></i></li>

                    </ul>
                </div>
            </div>
            <div>

                <div class="card-block">
                            @include('admin.message')
                    <form method="post" action="{{ route('admin.user.profile',['id'=>Crypt::encrypt($user->id)]) }}">
                        @csrf
                        <div class="row">
                        <div class="form-group col-lg-4">
                        <input value="{{$user->ownid}}" type="text" disabled class="form-control @error('ownid') is-invalid @enderror" placeholder="User Id">
                            @error('ownid')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="form-group col-lg-4">
                            <input value="{{$user->sponsarid}}" type="text" disabled class="form-control @error('sponsarid') is-invalid @enderror" placeholder="Sponsar Id">
                            @error('sponsarid')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="form-group col-lg-4">
                            <input type="mobile" name="mobile" id="mobile" value="{{$user->mobile}}"  class="form-control @error('mobile') is-invalid @enderror" placeholder="Mobile" >
                            @error('mobile')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                         <div class="form-group col-lg-4">
                            <input type="number" min="0" name="level" id="level" value="{{$user->currentlevel}}"  class="form-control @error('level') is-invalid @enderror" placeholder="Current Level" >
                            @error('level')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="form-group col-lg-4">
                            <input type="text" value="{{$user->name}}" name="name" class="form-control @error('name') is-invalid @enderror" placeholder="User Name">
                            @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="form-group col-lg-4">
                            <input type="date" name="dob" value="{{$user->dob}}" class="form-control @error('dob') is-invalid @enderror" placeholder="DOB">
                            @error('dob')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="form-group col-lg-4">
                            <input type="email" name="email" value="{{$user->email }}" class="form-control @error('email') is-invalid @enderror" placeholder="Email Address">
                            @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="form-group col-lg-8">
                            <input type="text" name="address" value="{{$user->address}}" class="form-control @error('address') is-invalid @enderror" placeholder="Address">
                            @error('address')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <button class="btn btn-primary" type="submit" style="margin:15px">Update Profile</button>

                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
