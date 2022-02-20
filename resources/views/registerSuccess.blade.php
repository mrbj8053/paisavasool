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
      <style>
          body{
    height: 100%;max-height: unset;background: url('https://wallpaperaccess.com/full/1267580.jpg');
}
      </style>
@include('headercss')
</head>
<body class="fix-menu" >

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

    @csrf

<div class="auth-box card" style="
    background: white;
    padding: 10px;
    border-radius: 8px;
    opacity: 0.9;
">
<div class="card-block">
    <div class="text-center">
       
        </div>
<div class="row m-b-20 text-center">
<div class="col-md-12 mt-2">
<h3 class="text-center">Congratulations</h3>
</div>
<div class="col-lg-12">
<p>Hello <strong>{{$user->name}}</strong> welcome to {{ config('app.name','Laravel')}} you are successfully registered.  </p>
<h4>Your user id is :</h4>
<h3 style="
    /* width: fit-content; */
    padding: 8px;
    text-align: center;
    border: 4px dotted red;
    background: antiquewhite;
">{{$user->ownid}}</h3>
<style>
    table,tr,td{
        border:1px solid black;
        padding: 5px;
        margin: auto;
    }
</style>
<table>
    <tr>
        <td style="color:black;font-weight:600;background: blanchedalmond;">Mobile : </td>
        <td>{{$user->mobile}}</td>
    </tr>
     <tr>
        <td style="color:black;font-weight:600;background: blanchedalmond;">Password : </td>
        <td>{{Crypt::decrypt($user->passwordcrypt)}}</td>
    </tr>
      <tr>
        <td style="color:black;font-weight:600;background: blanchedalmond;">Txn Password : </td>
        <td>{{Crypt::decrypt($user->txnpassword)}}</td>
    </tr> 
     <tr>
        <td style="color:black;font-weight:600;background: blanchedalmond;">Invite Id : </td>
        <td>{{$user->sponsarid}}</td>
    </tr>
</table>
</div>
</div>
<div class="row m-t-30">
<div class="col-md-12" style="text-align:center">
<a href="{{ route('login') }}" class="btn btn-primary btn-md btn-block waves-effect waves-light text-center m-b-20">Sign in to continue</a>
</div>
</div>
<hr />
</div>
</div>

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
