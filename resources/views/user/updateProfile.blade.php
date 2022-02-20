@extends('user.master')
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
                            @include('user.message')
                    <form method="post" enctype="multipart/form-data" action="{{route("user.profile.update")}}" >
                        @csrf
                        <div class="row">
                             <div class="form-group col-lg-4">
                                 @if(!empty(Auth::user()->profile))
                                {{-- <img src="{{asset("profile")."/".Auth::user()->profile}}" style="width:150px;height:150px" > --}}
                                 @endif
                                 <label for="profile">Profile Image</label>
                        <input  type="file" name="profile"  class="form-control @error('profile') is-invalid @enderror">
                            @error('profile')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="form-group col-lg-4">
                             <label>Ownid</label>
                        <input value="{{Auth::user()->ownid}}" type="text" disabled class="form-control @error('ownid') is-invalid @enderror" placeholder="User Id">
                            @error('ownid')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="form-group col-lg-4">
                            <label>Sponsar ID</label>
                            <input value="{{Auth::user()->sponsarid}}" type="text" disabled class="form-control @error('sponsarid') is-invalid @enderror" placeholder="Sponsar Id">
                            @error('sponsarid')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="form-group col-lg-4">
                            <label>Mobile</label>
                            <input type="mobile" value="{{Auth::user()->mobile}}"  class="form-control @error('mobile') is-invalid @enderror" placeholder="Mobile" disabled>
                            @error('mobile')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="form-group col-lg-4">
                            <label>Name</label>
                            <input type="text" value="{{Auth::user()->name}}" name="name" class="form-control @error('name') is-invalid @enderror" placeholder="User Name">
                            @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="form-group col-lg-4">
                            <label>DOB</label>
                            <input type="date" name="dob" value="{{Auth::user()->dob}}" class="form-control @error('dob') is-invalid @enderror" placeholder="DOB">
                            @error('dob')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="form-group col-lg-4">
                            <label>Email</label>
                            <input type="email" name="email" value="{{Auth::user()->email }}" class="form-control @error('email') is-invalid @enderror" placeholder="Email Address">
                            @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="form-group col-lg-12">
                            <label>Address</label>
                            <input type="text" name="address" value="{{Auth::user()->address}}" class="form-control @error('address') is-invalid @enderror" placeholder="Address">
                            @error('address')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                       {{-- @if(Auth::user()->kyc!=2)
                        <button class="btn btn-primary" type="submit" style="margin:15px">Update Profile</button>
                        @endif
                        </div> --}}
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
