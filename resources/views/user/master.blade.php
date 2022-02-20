<!DOCTYPE HTML>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1, viewport-fit=cover" />
    <title>{{config('app.name')}}</title>
    <link rel="stylesheet" type="text/css" href="{{asset('web')}}/styles/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="{{asset('web')}}/fonts/bootstrap-icons.css">
    <link rel="stylesheet" type="text/css" href="{{asset('web')}}/styles/style.css">
    <link rel="preconnect" href="https://fonts.gstatic.com/">
    <link href="https://fonts.googleapis.com/css2?family=Source+Sans+Pro:wght@500;600;700&amp;family=Roboto:wght@400;500;700&amp;display=swap" rel="stylesheet">
    <!-- <link rel="manifest" href="_manifest.html"> -->
    <meta id="theme-check" name="theme-color" content="#FFFFFF">
    <link rel="apple-touch-icon" sizes="180x180" href="app/icons/icon-192x192.html">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
    <style>
        .card-style {
            overflow: hidden;
            border-radius: 22px;
            margin: 0 5px 12px;
            border: none;
            box-shadow: rgb(0 0 0 / 3%) 0 20px 25px -5px, rgb(0 0 0 / 2%) 0 10px 10px -5px;
            background-size: cover;
            background-repeat: no-repeat;
            background-position: center center;
        }
        .invalid-feedback {
    display: block;
    width: 100%;
    margin-top: 0.25rem;
    font-size: .875em;
    color: #dc3545;
}
.copyBtn{
        background: green;
    color: white;
    padding: 6px;
    margin: 10px;
    border-radius: 10px;
}
    </style>
</head>

<body class="theme-light">
    <div id="preloader">
        <div class="spinner-border color-highlight" role="status"></div>
    </div>

    <div id="page">

        <div id="footer-bar" class="footer-bar-1 footer-bar-detached">
            <a href="{{route('user.sale.packages')}}" ><i class="bi bi-gem"></i><span>Trading</span></a>
            <a href="{{route('user.trading')}}" ><i class="bi bi-graph-up"></i><span>Invest</span></a>
            <a href="{{route('home')}}" class="circle-nav-2"><i class="bi bi-house-fill"></i><span>Home</span></a>
            <a href="{{route('user.profile')}}"><i class="bi bi-person-fill"></i><span>Profile</span></a>
            <a href="{{route('user.share')}}"><i class="bi bi-share-fill"></i><span>Share</span></a>
        </div>

        <div class="page-content footer-clear">

            <div class="pt-3" style="background-color: #0093E9;background-image: linear-gradient(160deg, #0093E9 0%, #80D0C7 100%);">
                <div class="page-title d-flex">
                    <div class="align-self-center me-auto">
                        <p class="color-white opacity-80 header-date"></p>
                        <h4 class="color-white">Welcome :{{Auth::user()->mobile}}</h4>
                    </div>
                    <div class="align-self-center ms-auto">
                        
                        <!--<a href="#" data-bs-toggle="offcanvas" data-bs-target="#menu-notifications" class="icon bg-white color-theme rounded-m shadow-xl">-->
                        <!--    <i class="bi bi-bell-fill color-black font-17"></i>-->
                        <!--    <em class="badge bg-red-light color-white scale-box">3</em>-->
                        <!--</a>-->
                        <a href="#" data-bs-toggle="dropdown" class="icon rounded-m shadow-xl">
                            <img src="{{asset('logo.png')}}" width="45" class="rounded-m" alt="img">
                        </a>

                        <div class="dropdown-menu">
                            <div class="card card-style shadow-m mt-1 me-1">
                                <div class="list-group list-custom list-group-s list-group-flush rounded-xs px-3 py-1">
                                    <a href="#" class="list-group-item">
                                        <i class="has-bg gradient-green shadow-bg shadow-bg-xs color-white rounded-xs bi bi-credit-card"></i>
                                        <strong class="font-13">Wallet</strong>
                                    </a>
                                    <a href="#" class="list-group-item">
                                        <i class="has-bg gradient-blue shadow-bg shadow-bg-xs color-white rounded-xs bi bi-graph-up"></i>
                                        <strong class="font-13">Activity</strong>
                                    </a>
                                    <a href="#" class="list-group-item">
                                        <i class="has-bg gradient-yellow shadow-bg shadow-bg-xs color-white rounded-xs bi bi-person-circle"></i>
                                        <strong class="font-13">Account</strong>
                                    </a>
                                    <a href="#" class="list-group-item">
                                        <i class="has-bg gradient-red shadow-bg shadow-bg-xs color-white rounded-xs bi bi-power"></i>
                                        <strong class="font-13">Log Out</strong>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @yield('content')

            </div>




</div>

<!-- <script src="scripts/bootstrap.min.html"></script> -->
<script src="{{ asset('web/') }}/scripts/custom.js"></script>
<script>
    function copyToClipBoard($epin)
    {
        var input = document.createElement('input');
    input.setAttribute('value', $epin);
    document.body.appendChild(input);
    input.select();
    var result = document.execCommand('copy');
    document.body.removeChild(input);
    alert('Referal URL "'+$epin+'" copied to clipboard');
    }
</script>
</body>