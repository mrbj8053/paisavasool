<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>{{ config('app.name') }}</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="{{asset('website')}}/img/favicon.png" rel="icon">
  <link href="{{asset('website')}}/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Raleway:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="{{asset('website')}}/vendor/aos/aos.css" rel="stylesheet">
  <link href="{{asset('website')}}/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="{{asset('website')}}/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="{{asset('website')}}/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="{{asset('website')}}/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
  <link href="{{asset('website')}}/vendor/remixicon/remixicon.css" rel="stylesheet">
  <link href="{{asset('website')}}/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="{{asset('website')}}/css/style.css" rel="stylesheet">
   <style>
    #footer .footer-newsletter form .submitbtn {
        position: absolute;
        top: 0;
        right: -2px;
        bottom: 0;
        border: 0;
        background: none;
        font-size: 16px;
        padding: 0 20px;
        background: #009970;
        color: #fff;
        transition: 0.3s;
        border-radius: 50px;
        box-shadow: 0px 2px 15px rgb(0 0 0 / 10%);
    }
   </style>
</head>

<body>

  <!-- ======= Header ======= -->
  <header id="header" class="fixed-top d-flex align-items-center">
    <div class="container">
      <div class="header-container d-flex align-items-center justify-content-between">
        <div class="logo">
          {{-- <h1 class="text-light"><a href="{{ route('welcome') }}"><span>{{ config('app.name') }}</span></a></h1> --}}
        <a href="{{ route('welcome') }}"><img src="{{asset('website')}}/logo.png" alt="" class="img-fluid"></a>
        </div>

        <nav id="navbar" class="navbar">
          <ul>
            <li><a class="nav-link scrollto active" href="#hero">Home</a></li>
            <li><a class="nav-link scrollto" href="#about">About</a></li>
            <li><a class="nav-link scrollto" href="#video">Video</a></li>
            <li><a class="nav-link scrollto " href="#achievers">Achievers</a></li>
            <li><a class="nav-link scrollto" href="#gallery">Gallery</a></li>
            <li><a class="nav-link scrollto" href="{{ route('zoom_meeting') }}">Zoom Meeting</a></li>
            <li><a class="getstarted scrollto" href="{{ route('login') }}">Login</a></li>
          </ul>
          <i class="bi bi-list mobile-nav-toggle"></i>
        </nav><!-- .navbar -->

      </div><!-- End Header Container -->
    </div>
  </header><!-- End Header -->

  <!-- ======= Hero Section ======= -->
  <section id="hero" class="d-flex align-items-center">
    <div class="container text-center position-relative" data-aos="fade-in" data-aos-delay="200">
      <h1>Your New Online Presence with {{ config('app.name') }}</h1>
      <h2>We are team of talented designers making websites with Bootstrap</h2>
      <a href="#about" class="btn-get-started scrollto">Get Started</a>
    </div>
  </section>
  <!-- End Hero -->

   @yield('content')

  <!-- ======= Footer ======= -->
  <footer id="footer">

    <div class="footer-top">
      <div class="container">
        <div class="row">

          <div class="col-lg-3 col-md-6 footer-contact">
            <h3>{{ config('app.name') }}</h3>
            <p>
                {{ config('app.address') }}
                <br>
              <strong>Phone:</strong> {{ config('app.mobile') }}<br>
              <strong>Email:</strong> {{ config('app.email') }}<br>
            </p>
          </div>

          <div class="col-lg-2 col-md-6 footer-links">
            <h4>Quick Links</h4>
            <ul>
              <li><i class="bx bx-chevron-right"></i> <a href="{{ route('welcome') }}">Home</a></li>
              <li><i class="bx bx-chevron-right"></i> <a href="#about">About us</a></li>
              <li><i class="bx bx-chevron-right"></i> <a href="#video">Video</a></li>
              <li><i class="bx bx-chevron-right"></i> <a href="#gallery">Gallery</a></li>
              <li><i class="bx bx-chevron-right"></i> <a href="#achievers">Achievers</a></li>
            </ul>
          </div>

          <div class="col-lg-3 col-md-6 footer-links">
            <h4>Our Services</h4>
            <ul>
              <li><i class="bx bx-chevron-right"></i> <a href="#">Web Design</a></li>
              <li><i class="bx bx-chevron-right"></i> <a href="#">Web Development</a></li>
              <li><i class="bx bx-chevron-right"></i> <a href="#">Product Management</a></li>
              <li><i class="bx bx-chevron-right"></i> <a href="#">Marketing</a></li>
              <li><i class="bx bx-chevron-right"></i> <a href="#">Graphic Design</a></li>
            </ul>
          </div>

          <div class="col-lg-4 col-md-6 footer-newsletter">
            <h4>Join Our Newsletter</h4>
            <p>Tamen quem nulla quae legam multos aute sint culpa legam noster magna</p>
            <form action="" method="post">
              <input type="email" name="email"><input type="button" class="submitbtn" value="Subscribe">
            </form>
          </div>

        </div>
      </div>
    </div>

    <div class="container  py-3">

      <div class="me-md-auto text-center">
        <div class="copyright">
          Copyright <strong><span>{{ config('app.name') }}</span></strong>. All Rights Reserved
        </div>

      </div>

    </div>
  </footer><!-- End Footer -->

  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Vendor JS Files -->
  <script src="{{asset('website')}}/vendor/purecounter/purecounter.js"></script>
  <script src="{{asset('website')}}/vendor/aos/aos.js"></script>
  <script src="{{asset('website')}}/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="{{asset('website')}}/vendor/glightbox/js/glightbox.min.js"></script>
  <script src="{{asset('website')}}/vendor/isotope-layout/isotope.pkgd.min.js"></script>
  <script src="{{asset('website')}}/vendor/swiper/swiper-bundle.min.js"></script>
  <script src="{{asset('website')}}/vendor/php-email-form/validate.js"></script>

  <!-- Template Main JS File -->
  <script src="{{asset('website')}}/js/main.js"></script>

</body>

</html>
