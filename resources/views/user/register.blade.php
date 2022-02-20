<!DOCTYPE html>
<html lang="en">

<!-- Mirrored from colorlib.com//polygon/adminty/default/auth-normal-sign-in.html by HTTrack Website Copier/3.x [XR&CO'2014], Fri, 09 Oct 2020 05:17:13 GMT -->
<!-- Added by HTTrack --><meta http-equiv="content-type" content="text/html;charset=UTF-8" /><!-- /Added by HTTrack -->
<head>
<title>{{ config('app.name', 'Laravel') }} </title>

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
    <form class="md-float-material form-material">
        <div class="text-center">
        <img src="{{ asset('web') }}/logo.png" alt="logo.png">
        </div>
        <div class="auth-box card">
        <div class="card-block">
        <div class="row m-b-20">
        <div class="col-md-12">
        <h3 class="text-center txt-primary">Sign up</h3>
        </div>
        </div>
        <div class="form-group form-primary">
        <input type="text" name="user-name" class="form-control" required="" placeholder="Choose Username">
        <span class="form-bar"></span>
        </div>
        <div class="form-group form-primary">
        <input type="text" name="email" class="form-control" required="" placeholder="Your Email Address">
        <span class="form-bar"></span>
        </div>
        <div class="row">
        <div class="col-sm-6">
         <div class="form-group form-primary">
        <input type="password" name="password" class="form-control" required="" placeholder="Password">
        <span class="form-bar"></span>
        </div>
        </div>
        <div class="col-sm-6">
        <div class="form-group form-primary">
        <input type="password" name="confirm-password" class="form-control" required="" placeholder="Confirm Password">
        <span class="form-bar"></span>
        </div>
        </div>
        </div>
        <div class="row m-t-25 text-left">
        <div class="col-md-12">
        <div class="checkbox-fade fade-in-primary">
        <label>
        <input type="checkbox" value="">
        <span class="cr"><i class="cr-icon icofont icofont-ui-check txt-primary"></i></span>
        <span class="text-inverse">I read and accept <a href="#">Terms &amp; Conditions.</a></span>
        </label>
        </div>
        </div>
        <div class="col-md-12">
        <div class="checkbox-fade fade-in-primary">
        <label>
        <input type="checkbox" value="">
        <span class="cr"><i class="cr-icon icofont icofont-ui-check txt-primary"></i></span>
        <span class="text-inverse">Send me the <a href="#!">Newsletter</a> weekly.</span>
        </label>
        </div>
        </div>
        </div>
        <div class="row m-t-30">
        <div class="col-md-12">
        <button type="button" class="btn btn-primary btn-md btn-block waves-effect text-center m-b-20">Sign up now</button>
        </div>
        </div>
        <hr>
        <div class="row">
        <div class="col-md-10">
        <p class="text-inverse text-left m-b-0">Thank you.</p>
        <p class="text-inverse text-left"><a href="index.html"><b class="f-w-600">Back to website</b></a></p>
        </div>
        <div class="col-md-2">
        <img src="../files/assets/images/auth/Logo-small-bottom.png" alt="small-logo.png">
        </div>
        </div>
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
