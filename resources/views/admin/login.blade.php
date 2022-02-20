<!DOCTYPE html>
<html lang="en">

<!-- Mirrored from colorlib.com//polygon/adminty/default/auth-normal-sign-in.html by HTTrack Website Copier/3.x [XR&CO'2014], Fri, 09 Oct 2020 05:17:13 GMT -->
<!-- Added by HTTrack --><meta http-equiv="content-type" content="text/html;charset=UTF-8" /><!-- /Added by HTTrack -->
<head>
<title>{{ config('app.name', 'Laravel') }} </title>


<!--[if lt IE 10]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
      <![endif]-->
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

<section class="login-block" style="background:url({{asset('background.png')}});background-repeat: no-repeat;background-size: cover;">

<div class="container">
<div class="row">
<div class="col-sm-12">
    @include('admin.message')
<form method="POST" action="{{ route('admin.login.submit') }}" class="md-float-material form-material" autocomplete="off">
    @csrf

<div class="auth-box card">
<div class="card-block">
    <div class="text-center mb-3">
        <img src="{{ asset('/') }}/logo.png" style="width:200px" alt="logo.png">
        </div>
<div class="row m-b-20">
<div class="col-md-12">
<h3 class="text-center">{{config('app.name','Laravel')}} Admin Panel</h3>

<p class="text-center">Sign In</p>
</div>
</div>
<div class="form-group form-primary">
<input type="email"  name="email" class="form-control @error('ownid') is-invalid @enderror" required="" placeholder="Email">
@error('email')
<span class="invalid-feedback" role="alert">
    <strong>{{ $message }}</strong>
</span>
@enderror
<span class="form-bar"></span>
</div>



<div class="form-group ">
                                    <div class="input-group input-group-merge input-group-alternative">
                                    <div class="input-group-prepend">
                                      <span class="input-group-text"><i class="ni ni-lock-circle-open"></i></span>
                                    </div>
                                      <div class="toggle-input-container">
                                    <input class="passwordToggle form-control @error('password') is-invalid @enderror" name="password" required  minlength="6" autocomplete="current-password" placeholder="Password" type="password">
                                    <i class="fa fa-eye toggle-icon toggler"></i>
                                    @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                                </div>
                                  </div>
                                </div>
<div class="row m-t-25 text-left">
<div class="col-12">
<div class="checkbox-fade fade-in-primary d-">
<label>
<input type="checkbox"  name="remember" id="remember" value="" {{ old('remember') ? 'checked' : '' }}>
<span class="cr"><i class="cr-icon icofont icofont-ui-check txt-primary"></i></span>
<span class="text-inverse">Remember me</span>
</label>
</div>
</div>
</div>
<div class="row m-t-30">
<div class="col-md-12">
<button type="submit" class="btn btn-primary btn-md btn-block waves-effect waves-light text-center m-b-20">Sign in</button>
</div>
</div>
<hr />
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
