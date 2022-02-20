@extends('master')
@section('content')
<!-- Section: Intro -->
<div class="full-title">
    <div class="container">
      <h1 class="mt-4 mb-3">Zoom Meeting</h1>
      <div class="breadcrumb-main">
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="{{ route('welcome') }}">Home</a></li>
          <li class="breadcrumb-item active">Zoom Meeting</li>
        </ol>
      </div>
    </div>
  </div>
<section class="bg-silver-light pt-3">
    <div class="container">
        <div class="section-content text-center">

            <div class="row mt-40 mb-5">
                @foreach (userHelper::get_zoommeetingall() as $zoom)

                <div class="col-lg-4">
                    <div class="post bg-white">

                        <div style="text-align: left;" class="entry-content icon-box p-40 mb-sm-50 border-bottom-2px border-theme-colored2 iconbox-theme-colored2 position-relative">
                            <a class="icon icon-top bg-theme-colored2 icon-circled icon-border-effect effect-circled" href="javascript:void(0)">
                                <i class="fa fa-btc text-white"></i>
                            </a>
                            <h3 class="icon-box-title">{{$zoom->title}}</h3>
                            <h5 class="mt-0">{{ $zoom->description }}</h5>
                            <p>Topic : {{ $zoom->topic }}</p>
                            <p>Time : {{ \Carbon\Carbon::parse($zoom->time)->format("d-m-Y H:i A") }}</p>
                            <p>Meeting ID : {{ $zoom->meeting_id }}</p>
                            <p>Passcode : {{ $zoom->passcode }}</p>
                            @if($zoom->link=='')
                            @else
                            <a href="{{ $zoom->link }}" target="_blank" class="btn btn-primary" style="background:#009970;border:#009970">Join {{ $zoom->title }}</a>
                           @endif
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</section>



@endsection
