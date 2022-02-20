<!DOCTYPE html>
<html lang="en">

<!-- Mirrored from colorlib.com//polygon/adminty/default/auth-normal-sign-in.html by HTTrack Website Copier/3.x [XR&CO'2014], Fri, 09 Oct 2020 05:17:13 GMT -->
<!-- Added by HTTrack --><meta http-equiv="content-type" content="text/html;charset=UTF-8" /><!-- /Added by HTTrack -->
<head>
<title>Make Royal World</title>

@include('headercss')
</head>
<body class="fix-menu">
<div class="theme-loader">
<div class="ball-scale">
<div class='contain'>
<div class="ring"><div class="frame"></div></div>
</div>
</div>
</div>

<section class="login-block">

<div class="container">
<div class="row">
<div class="col-sm-12">
    @include('user.message')
    <form class="md-float-material form-material" autocomplete="off" aria-autocomplete="none" role="form" method="POST" action="{{ route('user.register.submit') }}">
        @csrf
        
        <div class="auth-box card">
        <div class="card-block">
          <div class="text-center">
            <img src="{{ asset('web') }}/logo.png" style="width:100px;height:100px" alt="logo.png">
            </div>
        <div class="row m-b-20">
        <div class="col-md-12">
        <h3 class="text-center txt-primary">Sign up</h3>
        </div>
        </div>
        @include('user.message')
        <div class="form-group">
        <label class="form-control-label" for="input-username">Sponsar ID :</label>
          <div class="">
            <div class="input-group-prepend">
              <span class="input-group-text"><i class="ni ni-circle-08"></i></span>
            </div>
            <input id="spid"  onchange="getSponsar(this.value)"  class="form-control @error('SponsarId') is-invalid @enderror" value="{{ old('SponsarId') }}" name="SponsarId" placeholder="Sponsar Id" required minlength="9" maxlength="9" type="text" style=color:black;font-weight: 600;">
            @error('SponsarId')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
             @enderror
          </div>
        
           <p id="SponsarId" style="font-weight:bold;">
        </div>

      <div class="form-group">
        <label class="form-control-label" for="input-username">Name :</label>
        <div class="">
          <div class="input-group-prepend">
            <span class="input-group-text"><i class="ni ni-hat-3"></i></span>
          </div>
          <input class="form-control  @error('Name') is-invalid @enderror" value="{{ old('Name') }}" placeholder="Name"  name="Name" type="text" required style=color:black;font-weight: 600;" >
          @error('Name')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
      </div>
      </div>
      <div class="form-group">
        <label class="form-control-label" for="input-username">DOB :</label>
        <div class="">
          <div class="input-group-prepend">
            <span class="input-group-text"><i class="ni ni-hat-3"></i></span>
          </div>
          <input class="form-control  @error('DOB') is-invalid @enderror" value="{{ old('DOB') }}" placeholder="DOB"  name="DOB" type="date" required style=color:black;font-weight: 600;" >
          @error('DOB')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
      </div>
      </div>
      <div class="form-group">
        <label class="form-control-label" for="input-username">Mobile :</label>
          <div class="">
            <div class="input-group-prepend">
              <span class="input-group-text"><i class="ni ni-email-83"></i></span>
            </div>
            <input class="form-control  @error('Mobile') is-invalid @enderror" value="{{ old('Mobile') }}" placeholder="Mobile" name="Mobile" required minlength="10" maxlength="10"  type="number" style=color:black;font-weight: 600;">
            @error('Mobile')
          <span class="invalid-feedback" role="alert">
              <strong>{{ $message }}</strong>
          </span>
      @enderror
          </div>
        </div>
        <div class="form-group" style="display:none">
        <label class="form-control-label" for="input-username">Epin :</label>
            <div class="">
              <div class="input-group-prepend">
                <span class="input-group-text"><i class="ni ni-key-25"></i></span>
              </div>
              <input class="form-control  @error('Epin') is-invalid @enderror" value="{{ old('Epin') }}" placeholder="E-PIN" name="Epin" minlength="10"  maxlength="10" type="text" style=color:black;font-weight: 600;">
              @error('Epin')
              <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
              </span>
          @enderror
            </div>
          </div>
      <div class="form-group">
        <label class="form-control-label" for="input-username">Password :</label>
        <div class="">
          <div class="input-group-prepend">
            <span class="input-group-text"><i class="ni ni-lock-circle-open"></i></span>
          </div>
          <input class="form-control @error('Password') is-invalid @enderror" value="{{ old('Password') }}" required minlength="6" maxlength="50" placeholder="Password" name="Password" type="password" style=color:black;font-weight: 600;">
          @error('Password')
          <span class="invalid-feedback" role="alert">
              <strong>{{ $message }}</strong>
          </span>
      @enderror
      </div>
      </div>
      <div class="form-group">
        <label class="form-control-label" for="input-username">Confirm Password :</label>
          <div class="">
            <div class="input-group-prepend">
              <span class="input-group-text"><i class="ni ni-lock-circle-open"></i></span>
            </div>
            <input class="form-control @error('ConfirmPassword') is-invalid @enderror" value="{{ old('ConfirmPassword') }}" required minlength="6" maxlength="50" placeholder="Confirm Password" name="ConfirmPassword" type="password" style=color:black;font-weight: 600;">
            @error('ConfirmPassword')
          <span class="invalid-feedback" role="alert">
              <strong>{{ $message }}</strong>
          </span>
      @enderror
          </div>
        </div>
      <div class="row my-4">
        <div class="col-12">
          <div class="">
            <input required class="control @error('AgreeTerms') is-invalid @enderror" name="AgreeTerms" value="{{ old('AgreeTerms') }}" id="customCheckRegister" type="checkbox">
            @error('AgreeTerms')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
            <label class="" for="customCheckRegister">
              <span  class="text-muted">I agree with the <a href="{{ asset("terms.pdf") }}" target="_blank">Privacy Policy</a></span>
            </label>
          </div>
        </div>
        </div>
        <div class="row m-t-1">
        <div class="col-md-12">
        <button type="submit" class="btn btn-primary btn-md btn-block waves-effect text-center m-b-20">Sign up now</button>
        </div>
        </div>
        <hr>
       
        </div>
        </div>
        </form>

</div>

</div>

</div>

</section>
{{--Footer section start --}}
@include('footerjs')
{{--Footer section end--}}
</body>

<!-- Mirrored from colorlib.com//polygon/adminty/default/auth-normal-sign-in.html by HTTrack Website Copier/3.x [XR&CO'2014], Fri, 09 Oct 2020 05:17:13 GMT -->
</html>
