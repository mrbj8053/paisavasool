@extends('user.master')
@section('content')

@if(Auth::user()->currentplan==0)
<div class="card card-style">
                <div class="content">
                    <div class=" py-1 text-center">

                        <h1>No Package Applied</h1>
                        <img src="{{asset('packages/mining.jpg')}}" style="width:150px;margin:auto" />
                        <h5>Apply For a package to start Cloud Mining</h5>
                    </div>



                </div>
            </div>

@else
<div class="card card-style">
                <div class="content">
                    <div class=" py-1">

                        <div class="text-center align-self-center ps-1" style="
    display: flex;
    justify-content: space-between;
">
                            @php 
                            $recordROI=userHelper::getDailyROI(Auth::user()->ownid);
                            @endphp
                            @foreach($recordROI as $rec)
                            <h4 class="pt-1 pb-3 mb-n1" style="font-size: 20px;color: green;">{{ "$".$rec->name }} : + {{ $rec->daily  }} %</h4>
                            @endforeach
                        </div>
                        <div class="text-center align-self-center">
                            <img alt=".." src="{{asset('packages')}}/btcmining.gif" style="width: 100%;" />
                        </div>
                        <div class="text-center align-self-center ps-1 mt-3">
                            <h4 class="pt-1 pb-3 mb-n1" style="font-size: 20px;">Cloud Mining is working</h4>

                        </div>
                    </div>



                </div>
            </div>
            <div class="card card-style d-none">
                <div class="content">
                    <div class=" py-1">

                        <div class=" align-self-center ps-1">
                            <a href="#!"><h4 class="pt-1 pb-3 mb-n1" style="font-size: 20px;"><span>Trading profile</span><span style="    font-size: 14px;
                                float: right;margin-right: 19px;">View all <i class="ba bi-chevron-right"></i></span></h4></a>

                        </div>
                        @foreach($record as $rc)
                        <a href="#" class="d-flex py-1" data-bs-toggle="offcanvas" data-bs-target="#menu-activity-2">
                            <div class="align-self-center">
                                <span class="icon rounded-s me-2 gradient-brown shadow-bg shadow-bg-xs"><i class="bi bi-wallet color-white"></i></span>
                            </div>
                            <div class="align-self-center ps-1">
                                <h5 class="pt-1 mb-n1">{{ $rc->amount }} TRX</h5>
                                <p class="mb-0 font-11 opacity-70">{{ $rc->remark  }}</p>
                            </div>
                            <div class="align-self-center ms-auto text-end">

                                <button class="btn btn-success">Receive</button>
                            </div>
                        </a>
                        <hr>
                        @endforeach
                      
                    </div>



                </div>
            </div>
            
            @endif
            @endsection
