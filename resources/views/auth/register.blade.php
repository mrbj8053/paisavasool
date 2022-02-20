<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent" />
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1, viewport-fit=cover" />
    <title>{{config('app.name')}}</title>
    <link rel="stylesheet" type="text/css" href="{{asset('web')}}/styles/bootstrap.css" />
    <link rel="stylesheet" type="text/css" href="{{asset('web')}}/fonts/bootstrap-icons.css" />
    <link rel="stylesheet" type="text/css" href="{{asset('web')}}/styles/style.css" />
    <link rel="preconnect" href="https://fonts.gstatic.com/" />
    <link href="https://fonts.googleapis.com/css2?family=Source+Sans+Pro:wght@500;600;700&amp;family=Roboto:wght@400;500;700&amp;display=swap" rel="stylesheet" />
    <!-- <link rel="manifest" href="_manifest.html"> -->
    <meta id="theme-check" name="theme-color" content="#FFFFFF" />
    <link rel="apple-touch-icon" sizes="180x180" href="app/icons/icon-192x192.html" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css" />

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
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
        
        .nav-tabs .nav-link {
            margin-bottom: -1px;
            background: 0 0;
            border: 1px solid transparent;
            border-top-left-radius: 0.25rem;
            border-top-right-radius: 0.25rem;
            font-size: 20px;
        }
        .invalid-feedback {
    display: block;
    width: 100%;
    margin-top: 0.25rem;
    font-size: .875em;
    color: #dc3545;
}
body{
    height: 100%;max-height: unset;background: url('https://wallpaperaccess.com/full/1267580.jpg');
}
.form-custom>span{
    color:black;
    font-weight:600;
}
.text-center>a>span{
    color: black;
    font-weight: 600;
    background: green;
    padding: 10px;
    color: white;
    border-radius: 10px;
}

    </style>
</head>

<body class="theme-light" style="
    height: 100%;
    max-height: unset;
    background: url('https://wallpaperaccess.com/full/1267580.jpg');
">
    <div id="preloader">
        <div class="spinner-border color-highlight" role="status"></div>
    </div>

    <div id="page">
    <?php
        $url="https://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
        $values = parse_url($url);

        $host = explode('/',$values['path']);
        if(isset($host[2]))
        {
            $saponsar= $host[2];
        }



        ?>

        <div class="page-content footer-clear">
            
            <div class="card-center mt-5 mx-3 px-4 py-4 bg-white rounded-m">
                <img src="{{asset('logo.png')}}" style="border-radius: 13px;" />
                <h1 class="font-30 font-800 mb-0">{{config('app.name')}}</h1>
                <p>Create an account</p>
                 @include('user.message')
                <form action="{{ route('user.register.submit') }}" method="POST">
                  @csrf
                <div class="row">
                <div class="col-12 col-lg-6 col-md-6">
                        <div class="form-custom form-label form-border form-icon mb-3 bg-transparent">
                            <i class="bi bi-person-circle font-13"></i>
                            <input type="email" required  class="form-control rounded-xs @error('email') is-invalid @enderror" id="email" name="email" placeholder="Enter Email">
                            <label for="email" class="color-theme">Email</label>
                            <span>(required)</span>
                        </div>
                        @error('email')
<span class="invalid-feedback" role="alert">
    <strong>{{ $message }}</strong>
</span>
@enderror

                    </div>
                    <div class="col-12 col-lg-6 col-md-6">
                        <div class="form-custom form-label form-border form-icon mb-3 bg-transparent">
                            <i class="bi bi-person-circle font-13"></i>
                            <input type="number" required minlength="10" value="{{old('')}}" maxlength="10" class="form-control rounded-xs @error('mobile') is-invalid @enderror" id="mobile" name="mobile" placeholder="Mobile">
                            <label for="mobile" class="color-theme">Mobile</label>
                            <span>(required)</span>
                        </div>
                        @error('mobile')
<span class="invalid-feedback" role="alert">
    <strong>{{ $message }}</strong>
</span>
@enderror

                    </div>
                   
                    <div class="col-12 col-lg-6 col-md-6">
                        <div class="form-custom form-label form-border form-icon mb-3 bg-transparent">
                            <i class="bi bi-at font-16"></i>
                            <input type="text"  minlength="8" maxlength="9" class="form-control rounded-xs @error('inviteCode') is-invalid @enderror" value="{{ isset($saponsar)? $saponsar: old('inviteCode') }}" id="inviteCode" name="inviteCode" placeholder="Enter Invite code">
                            <label for="inviteCode" class="color-theme">Invite Code</label>
                            <span>(required)</span>
                        </div>
                        @error('inviteCode')
<span class="invalid-feedback" role="alert">
    <strong>{{ $message }}</strong>
</span>
@enderror

                    </div>
                    <div class="col-12 col-lg-6 col-md-6">
                        <div class="form-custom form-label form-border form-icon mb-3 bg-transparent">
                            <i class="bi bi-asterisk font-13"></i>
                            <input type="password" class="form-control rounded-xs @error('password') is-invalid @enderror" id="password"  name="password" placeholder="Choose Password">
                            <label for="password" class="color-theme">Choose Password</label>
                            <span>(required)</span>
                        </div>
                        @error('password')
<span class="invalid-feedback" role="alert">
    <strong>{{ $message }}</strong>
</span>
@enderror

                    </div>
                    <div class="col-12 col-lg-6 col-md-6">
                        <div class="form-custom form-label form-border form-icon mb-3 bg-transparent">
                            <i class="bi bi-asterisk font-13"></i>
                            <input type="password" class="form-control rounded-xs @error('txnPassword') is-invalid @enderror" id="txnPassword"  name="txnPassword" placeholder="Transaction Password">
                            <label for="txnPassword" class="color-theme">Transaction Password</label>
                            <span>(required)</span>
                        </div>
                        @error('txnPassword')
<span class="invalid-feedback" role="alert">
    <strong>{{ $message }}</strong>
</span>
@enderror

                    </div>
                   
                    <div class="col-12 col-lg-6 col-md-6 d-none">
                        <div class="form-check form-check-custom">
                            <input   class="form-check-input" type="checkbox" name="type" value="" id="c2a">
                            <label class="form-check-label font-12" for="c2a">I agree with the <a href="#">Terms and Conditions</a>.</label>
                            <i class="is-checked color-highlight font-13 bi bi-check-circle-fill"></i>
                            <i class="is-unchecked color-highlight font-13 bi bi-circle"></i>
                        </div>
                    </div>
                    <div class="col-12 col-lg-12 col-md-12 ">
                        <input type="submit" value="signup" class="btn btn-full gradient-highlight shadow-bg shadow-bg-s mt-4">
                    </div>
                </div>
      </form>
                <div class="row">

                    <div class="col-12 text-center">
                        <a href="{{route('login')}}" class="font-11 color-theme  pt-4 d-block"><span>Sign In Account</span></a>
                    </div>
                </div>
            </div>




        </div>

        <!-- <script src="scripts/bootstrap.min.html"></script> -->
        <script src="{{asset('web')}}/scripts/custom.js"></script>

</body>

</html>