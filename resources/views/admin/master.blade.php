<!DOCTYPE html>
<html lang="en">

<meta http-equiv="content-type" content="text/html;charset=UTF-8" />

<head>
<title>{{config('app.name','User Panel')}}- Admin Panel </title>

@include('headercss')
</head>

<body>

<div class="theme-loader">
<div class="ball-scale">
<div class='contain'>
<div class="ring">
<div class="frame"></div>
</div>
</div>
</div>
</div>

<div id="pcoded" class="pcoded">
<div class="pcoded-overlay-box"></div>
<div class="pcoded-container navbar-wrapper">
<nav class="navbar header-navbar pcoded-header">
<div class="navbar-wrapper">
<div class="navbar-logo">
<a class="mobile-menu" style="text-align:left" id="mobile-collapse" href="#!">
  <p><i class="fa fa-bars" style="font-size:25px"></i></p>
</a>
<a href="{{route("home")}}">
<h5></h5>
<img style="width:89px;" src="{{asset('logo.png')}}" alt="Theme-Logo" />
</a>
<a class="mobile-options">
<i class="feather icon-more-horizontal"></i>
</a>
</div>
<div class="navbar-container container-fluid">
<ul class="nav-left">

<li>
<a href="#!" onclick="javascript:toggleFullScreen()">
<i class="feather icon-maximize full-screen"></i>
</a>
</li>
</ul>
<ul class="nav-right">
    {{--Notification Start--}}
<li class="header-notification">
 <div class="dropdown-primary dropdown">

<ul class="show-notification notification-view dropdown-menu" data-dropdown-in="fadeIn" data-dropdown-out="fadeOut">
<li>
<h6>Notifications</h6>
<label class="label label-danger">New</label>
</li>
<li>
<div class="media">
<img class="d-flex align-self-center img-radius" src="../files/assets/images/avatar-4.jpg" alt="Generic placeholder image">
<div class="media-body">
<h5 class="notification-user">John Doe</h5>
<p class="notification-msg">Lorem ipsum dolor sit amet, consectetuer elit.</p>
<span class="notification-time">30 minutes ago</span>
</div>
</div>
</li>
<li>
<div class="media">
<img class="d-flex align-self-center img-radius" src="../files/assets/images/avatar-3.jpg" alt="Generic placeholder image">
<div class="media-body">
<h5 class="notification-user">Joseph William</h5>
<p class="notification-msg">Lorem ipsum dolor sit amet, consectetuer elit.</p>
<span class="notification-time">30 minutes ago</span>
</div>
</div>
</li>
<li>
<div class="media">
<img class="d-flex align-self-center img-radius" src="../files/assets/images/avatar-4.jpg" alt="Generic placeholder image">
<div class="media-body">
<h5 class="notification-user">Sara Soudein</h5>
<p class="notification-msg">Lorem ipsum dolor sit amet, consectetuer elit.</p>
<span class="notification-time">30 minutes ago</span>
</div>
</div>
</li>
</ul>
</div>
</li>
{{--Notification end--}}
<li class="user-profile header-notification">
<div class="dropdown-primary dropdown">
<div class="dropdown-toggle" data-toggle="dropdown">
<img src="{{ asset('web') }}/user.png" class="img-radius" alt="User-Profile-Image">
<span>{{Auth::user()->name." ( Admin Panel )"}}</span>
<i class="feather icon-chevron-down"></i>
</div>
<ul class="show-notification profile-notification dropdown-menu" data-dropdown-in="fadeIn" data-dropdown-out="fadeOut">

<li>
<a href="{{ route('admin.password') }}" >
    <i class="fa fa-key"></i> Change Password
</a>
</li>
<li>
<a href="javascript:void(0)" onclick="event.preventDefault();document.getElementById('logout-formnav').submit();">
<i class="feather icon-log-out"></i> Logout
</a>
</li>
</ul>
</div>
</li>
</ul>
</div>
</div>
</nav>
<div class="pcoded-main-container">
<div class="pcoded-wrapper">
<nav class="pcoded-navbar">
<div class="pcoded-inner-navbar main-menu">
<ul class="pcoded-item pcoded-left-item">
<li class="pcoded-hasmenu active pcoded-trigger">
<li class="active">
<a href="{{ route('admin.dashboard.home') }}">
  <span class="pcoded-micon"><i class="feather icon-home"></i><b>D</b></span>
<span class="pcoded-mtext">Dashboard</span>
</a>
</li>
<li >
<a href="{{ route('admin.firmdetails') }}">
  <span class="pcoded-micon"><i class="feather icon-home"></i><b>D</b></span>
<span class="pcoded-mtext">Firm Details</span>
</a>
</li>
<li class="d-none" >
<a href="{{ route('admin.gallery.show') }}" >
  <span class="pcoded-micon"><i class="fa fa-picture-o"></i><b>D</b></span>
<span class="pcoded-mtext">Gallery</span>
</a>
</li>
<li>
<a href="{{ route('admin.achievers.show') }}">
  <span class="pcoded-micon"><i class="fa fa-picture-o"></i><b>D</b></span>
<span class="pcoded-mtext">Upload Platforms</span>
</a>
</li>
<li class="d-none">
<a href="{{ route('admin.zoom_meeting.show') }}">
  <span class="pcoded-micon"><i class="fa fa-tree"></i><b>D</b></span>
<span class="pcoded-mtext">Zoom Meeting</span>
</a>
</li>
<li class="d-none">
<a href="{{ route('admin.video') }}">
  <span class="pcoded-micon"><i class="fa fa-picture-o"></i><b>D</b></span>
<span class="pcoded-mtext">Video</span>
</a>
</li>
<li class="d-none">
<a href="{{ route('admin.slider') }}">
  <span class="pcoded-micon"><i class="fa fa-picture-o"></i><b>D</b></span>
<span class="pcoded-mtext">Slider</span>
</a>
</li>
<li>
<a href="{{ route('admin.company.business') }}">
  <span class="pcoded-micon"><i class="fa fa-picture-o"></i><b>D</b></span>
<span class="pcoded-mtext">Company Business</span>
</a>
</li>

<ul class="pcoded-submenu">
<!-- <li class="">
<a href="index.html">
<span class="pcoded-mtext">Default</span>
</a>
</li> -->
<!-- <li class="active">
<a href="dashboard-crm.html">
<span class="pcoded-mtext">CRM</span>
</a>
</li> -->
<!-- <li class="">
<a href="dashboard-analytics.html">
<span class="pcoded-mtext">Analytics</span>
<span class="pcoded-badge label label-info ">NEW</span>
</a>
</li> -->
</ul>
</li>
{{-- <li class="pcoded-hasmenu">
<a href="javascript:void(0)">
<span class="pcoded-micon"><i class="feather icon-sidebar"></i></span>
<span class="pcoded-mtext">E-Pin</span>
{{-- <span class="pcoded-badge label label-warning">NEW</span>
</a>
<ul class="pcoded-submenu">
<li class=" pcoded">
        <a href="{{ route('admin.epin.transferred') }}">
         <span class="pcoded-mtext">E-pin Transferred</span>
         </a>
</li>
<li class=" pcoded">
<a href="{{ route('admin.epin.pending') }}">
<span class="pcoded-mtext">E-pin Pending (Generate)</span>
 </a>
</li>
<li class=" pcoded">
<a href="{{ route('admin.epin.used') }}">
<span class="pcoded-mtext">E-pin Used</span>
</a>
</li>
{{-- <li class=" pcoded">
<a href="{{ route('admin.epin.requests') }}">
<span class="pcoded-mtext">E-pin Requests</span>
</a>
</li>
</ul>
</li> --}}
<li class="pcoded-hasmenu">
    <a href="javascript:void(0)">
    <span class="pcoded-micon"><i class="feather icon-sidebar"></i></span>
    <span class="pcoded-mtext">Users</span>
    {{-- <span class="pcoded-badge label label-warning">NEW</span> --}}
    </a>
    <ul class="pcoded-submenu">
        <li class=" pcoded">
            <a href="{{ route('admin.user.password') }}">
            <span class="pcoded-mtext">Change user password</span>
             </a>
            </li>
        <li class=" pcoded">
            <a href="{{ route('admin.alluser') }}">
            <span class="pcoded-mtext">All Active Users</span>
             </a>
            </li>
            <li class=" pcoded">
            <a href="{{ route('admin.alluser.inactive') }}">
            <span class="pcoded-mtext">All Inactive Users</span>
             </a>
            </li>
              <li class="d-none pcoded">
            <a href="{{ route('admin.reward') }}">
            <span class="pcoded-mtext">Reward Members</span>
             </a>
            </li>
            <li class="d-none pcoded">
            <a href="{{ route('admin.reward.manual.show') }}">
            <span class="pcoded-mtext">Reward Give</span>
             </a>
            </li>

    <li class="pcoded">
        <a href="{{ route('admin.user.amount') }}">
        <span class="pcoded-mtext">Manage User Amount</span>
         </a>
        </li>

    </ul>
    </li>
<li class="pcoded-hasmenu d-none">
<a href="javascript:void(0)">
<span class="pcoded-micon"><i class="fa fa-home"></i></span>
<span class="pcoded-mtext">KYC</span>
</a>
<ul class="pcoded-submenu">
    <li >
<a href="{{ route('admin.user.kyc.pending.cnf') }}">
<span class="pcoded-mtext">KYC Pending</span>
</a>
</li>
<li >
<a href="{{ route('admin.user.kyc.pending') }}">
<span class="pcoded-mtext">KYC Uploaded</span>
</a>
</li>
<li>
<a href="{{ route('admin.user.kyc.done') }}">
<span class="pcoded-mtext">KYC Approved</span>
</a>
</li>
</ul>
</li>
<li class="pcoded-hasmenu">
<a href="javascript:void(0)">
<span class="pcoded-micon"><i class="fa fa-home"></i></span>
<span class="pcoded-mtext">Package Requests</span>
</a>
<ul class="pcoded-submenu">
<li >
<a href="{{ route('admin.package.request') }}">
<span class="pcoded-mtext">Pending Requests</span>
</a>
</li>
<li>
<a href="{{ route('admin.package.request',1) }}">
<span class="pcoded-mtext">Approved Requests</span>
</a>
</li>
</ul>
</li>
<li class="pcoded-hasmenu">
<a href="javascript:void(0)">
<span class="pcoded-micon"><i class="fa fa-home"></i></span>
<span class="pcoded-mtext">Tip Package Requests</span>
</a>
<ul class="pcoded-submenu">
<li >
<a href="{{ route('admin.salepackage.request') }}">
<span class="pcoded-mtext">Pending Requests</span>
</a>
</li>
<li>
<a href="{{ route('admin.salepackage.request',1) }}">
<span class="pcoded-mtext">Approved Requests</span>
</a>
</li>
</ul>
</li>

<li class="pcoded-hasmenu">
<a href="javascript:void(0)">
<span class="pcoded-micon"><i class="fa fa-home"></i></span>
<span class="pcoded-mtext">Income Reports</span>
</a>
<ul class="pcoded-submenu">
<li >
<a href="{{ route('admin.income',"Direct") }}">
<span class="pcoded-mtext">Direct Income</span>
</a>
</li>
<li>
<a href="{{ route('admin.income',"Level") }}">
<span class="pcoded-mtext">Level Income</span>
</a>
</li>
<li>
<a href="{{ route('admin.income',"ROI") }}">
<span class="pcoded-mtext">ROI Income</span>
</a>
</li>
<li>
<a href="{{ route('admin.income',"Ledger Summary") }}">
<span class="pcoded-mtext">Ledger Summary</span>
</a>
</li>
</ul>
</li>
<li class="pcoded-hasmenu">
    <a href="javascript:void(0)">
    <span class="pcoded-micon"><i class="fa fa-tree"></i></span>
    <span class="pcoded-mtext">Downline</span>
    </a>
    <ul class="pcoded-submenu">
    <li >
    <a href="javascript:void(0)" onclick="document.getElementById('tree-form').submit();">
    <span class="pcoded-mtext">Users Tree</span>
    </a>
    <form id="tree-form" action="{{ route('admin.showtree') }}" method="POST" >
        @csrf
        <input type="hidden" name="id" value="{{ Crypt::encrypt('VM0000000') }}">
        <input type="hidden" name="plan" value="Silver">

    </form>
    </li>
    {{-- <li >
    <a href="{{ route('user.downline') }}">
    <span class="pcoded-mtext">Show Downline</span>
    </a>
    </li> --}}

    </ul>
    </li>
<li class="pcoded-hasmenu">
<a href="javascript:void(0)">
<span class="pcoded-micon"><i class="fa fa-inr"></i></span>
<span class="pcoded-mtext">Withdraw</span>
</a>
<ul class="pcoded-submenu ">
<li class=" ">
<a href="{{ route('admin.withdraw.apply') }}">
<span class="pcoded-mtext">Withdraw Requests </span>
</a>
</li>
<li class=" ">
<a href="{{ route('admin.withdraw.pending') }}">
<span class="pcoded-mtext">Withdraw Declined </span>
</a>
</li>
 <li class="">
<a href="{{ route('admin.withdraw.paid') }}">
<span class="pcoded-mtext">Withdraw Accepted</span>
</a>
</li>  
</ul>
</li>
</ul>
<ul class="pcoded-item pcoded-left-item">
<li class="pcoded">
<a href="{{ route('admin.password') }}">
 <span class="pcoded-micon"> <i class="fa fa-key"></i></span>
<span class="pcoded-mtext">Change Password</span>
</a>
</li>
</ul>
<ul class="pcoded-item pcoded-left-item">
<li class="pcoded">
<a href="javascript:void(0)" onclick="event.preventDefault();
document.getElementById('logout-formnav').submit();">
 <span class="pcoded-micon"><i class="fa fa-sign-out"></i></span>
<span class="pcoded-mtext">Sign Out</span>
</a>
<form id="logout-formnav" action="{{ route('admin.logout') }}" method="POST" style="display: none;">
    @csrf
</form>
</li>
</ul>
</div>
</nav>
<div class="pcoded-content">
<div class="pcoded-inner-content">
<div class="main-body">
<div class="page-wrapper">
    <div class="page-body">
@yield('content')
    </div>
</div>
<!-- <div id="styleSelector"> -->
</div>
</div>
</div>
</div>
</div>
</div>
</div>
</div>

@include('footerjs')
</body>
<script>
    function confirmDeleteKYC(url)
    {
        if(confirm("Are you dure to delete this KYC ?"))
        {
            document.location.href=url;
        }
    }

</script>
</html>
