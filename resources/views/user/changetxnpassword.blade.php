@extends('user.master')
@section('content')
<div class="row justify-content-center">

       <div class="col-lg-8 col-md-8 col-12">
        <h3 style="text-align:center;"><b style="color:blue; font-size:24px;">Current Txn Password</b></h3>
    
        <div class="card" >
            <div class="card-header" style="font-size:19px;">
                <h5><i class="fa fa-edit"></i>&nbsp; &nbsp;Current Txn Password</h5>
                <span><!-- lorem ipsum dolor sit amet, consectetur adipisicing elit --></span>
                    <hr>
            </div>
            <div>
                <div class="card-block px-3">
                    @include('user.message')
                        <form action="{{route('user.changetxnpass')}}" method="post">
                            @csrf
                        <div class="col-lg-12 col-md-12 col-12">
                          <div class="form-group">
                            <label for="userid">Current Txn Password<span style="color:red;">*</span></label>
                            <input type="password" required class="form-control @error('OldPassword') is-invalid @enderror" name="OldPassword" value="{{ old('Password') }}" id="" placeholder="Current Password" name="password">
                            @error('OldPassword')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                          </div>
                        </div>
                        <hr>
                        <div class="col-lg-12 col-md-12 col-12">
                          <div class="form-group">
                            <label for="">New Password<span style="color:red;">*</span></label>
                            <input class="passwordToggle form-control @error('NewPassword') is-invalid @enderror" name="NewPassword" required autocomplete="current-password"  minlength="6" placeholder="New Password" type="password">
                                    <i class="fa fa-eye toggle-icon toggler"></i>
                                    @error('NewPassword')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                          </div>
                        </div>
                        <hr>  
                         <div class="col-lg-12 col-md-12 col-12">
                          <div class="form-group">
                            <label for="">Verify New Password<span style="color:red;">*</span></label>
                            <input class="passwordToggle form-control @error('ConfirmPassword') is-invalid @enderror" name="ConfirmPassword" required  minlength="6" autocomplete="current-password" placeholder="Confirm Password" type="password">
                                    <i class="fa fa-eye toggle-icon toggler"></i>
                                    @error('ConfirmPassword')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                          </div>
                        </div>
                        <hr>
                        <div class="col-lg-12 col-md-12 col-12">
                            <button type="submit" class="btn btn-default" style="background:blue; color:#fff;">Submit</button>
                           </div>
                        </form>
                      </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection