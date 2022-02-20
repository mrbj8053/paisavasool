@extends('user.master')
@section('content')
<div class="transition duration-300 ease-in-out delay-150">
                <img alt="..." src="{{asset('logo.png')}}" style="width: 100%;
                padding: 2px;
                border-radius: 24px;
                height: 200px;" />
            </div>

            <div class="mt-2 card card-style gradient-green shadow-bg shadow-bg-s">
                <div class="content">
                    <a href="#" class="d-flex">
                        <div class="align-self-center">
                            <h1 class="mb-0 font-40"><i class="bi bi-megaphone color-white pe-3"></i></h1>
                        </div>

                        <!--Breaking content-->
                        <div class="align-self-center">
                            <div class="breaking-box pt-2 pb-1">
                                <!--marque-->
                                <marquee behavior="scroll" direction="left" onmouseover="this.stop();" onmouseleave="this.start();">
                                
                                <a class="h6 font-weight-light" href="javascript:void(0)" style="color: #fff;">{{userHelper::getFirm()->news}}</a>
                                
                                </marquee>
                            </div>
                        </div>
                        

                        <div class="align-self-center ms-auto">
                            <h1 class="mb-0 font-40"></h1>
                        </div>
                    </a>
                </div>
            </div>
            <div class="mt-2 card card-style gradient-blue shadow-bg shadow-bg-s">
                <div class="content">
                    <a href="#" class="d-flex">
                        <div class="align-self-center">
                            <h1 class="mb-0 font-40"><i class="bi bi-megaphone color-white pe-3"></i></h1>
                        </div>

                        @php 
                        $sale=userHelper::checkPackageSale(Auth::user()->ownid);
                        
                        @endphp
                        @if(count($sale)>0 && $sale[count($sale)-1]->status==1 && $sale[count($sale)-1]->remaining>0)
                                                <div class="align-self-center" style="
    width: 100%;
">
                            <div class="breaking-box pt-2 pb-1">
                                <!--marque-->
                                <marquee behavior="scroll" direction="left" onmouseover="this.stop();" onmouseleave="this.start();">
                                
                                <a class="h6 font-weight-light" href="javascript:void(0)" style="color: #fff;">Today Tip :{{userHelper::getFirm()->dailytip."Reamaining tip days : ".$sale[count($sale)-1]->remaining}}</a>
                                
                                </marquee>
                            </div>
                        </div>
                        @endif
                        

                       
                    </a>
                </div>
            </div>
            <div class="content py-2">
                <div class="d-flex text-center">
                    <div class="me-auto">
                        <a href="{{route('user.trading.packages')}}" class="icon icon-xxl rounded-m bg-theme shadow-m"><i class="font-28 color-green-dark bi bi-arrow-up-circle"></i></a>
                        <h6 class="font-13 opacity-80 font-500 mb-0 pt-2">Deposit</h6>
                    </div>
                    <div class="m-auto">
                        <a href="{{route('user.withdraw.apply')}}" class="icon icon-xxl rounded-m bg-theme shadow-m"><i class="font-28 color-red-dark bi bi-arrow-down-circle"></i></a>
                        <h6 class="font-13 opacity-80 font-500 mb-0 pt-2">Withdrawal</h6>
                    </div>
                    <div class="ms-auto">
                        <a href="{{route('user.share')}}" class="icon icon-xxl rounded-m bg-theme shadow-m"><i class="font-28 color-blue-dark bi bi-share-fill"></i></a>
                        <h6 class="font-13 opacity-80 font-500 mb-0 pt-2">Share</h6>
                    </div>
                </div>
            </div>

            <div class="content py-2">
                <div class="d-flex text-center">

                    <div class="me-auto">
                        <a href="{{ route('user.downline') }}" class="icon icon-xxl rounded-m bg-theme shadow-m"><i class="font-28 color-green-dark bi bi-filter-circle"></i></a>
                        <h6 class="font-13 opacity-80 font-500 mb-0 pt-2">Team</h6>
                    </div>
                    <div class="m-auto">
                        <a href="{{asset('app.apk')}}" target="_blank" class="icon icon-xxl rounded-m bg-theme shadow-m"><i class="font-28 color-red-dark bi bi-filter-circle"></i></a>
                        <h6 class="font-13 opacity-80 font-500 mb-0 pt-2">App</h6>
                    </div>
                    <div class="ms-auto">
                        <a href="javascript:void(0)" onclick="event.preventDefault();
document.getElementById('logout-form').submit();" class="icon icon-xxl rounded-m bg-theme shadow-m"><i class="font-28 color-black-dark bi bi-dash-circle"></i></a>
                        <h6 class="font-13 opacity-80 font-500 mb-0 pt-2">Logout</h6>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
    @csrf
</form>
                    </div>
                </div>
            </div>


            <div class="d-flex">
                <div class="col-6 col-sm-6 col-lg-6 col-md-6">
                    <div class="card card-style">
                        <div class="content">
                            <a href="{{route('user.income',['Ledger Summary'])}}">
                            <div class=" py-1">
                                <div class="text-center align-self-center">
                                    <span class="icon rounded-s me-2 gradient-blue shadow-bg shadow-bg-s"><i class="bi bi-wallet color-white"></i></span>
                                </div>
                                <div class="text-center align-self-center ps-1">
                                    <h5 class="pt-1 mb-n1">Wallet</h5>
                                    <p class="mb-0 font-11 opacity-50">Account</p>
                                </div>
                                <h5 class="text-center pt-1 mb-n1">$ {{ round($netIncome,2) }} <sub style="color:#726f6f"> </sub></h5>

                            </div>
</a>


                        </div>
                    </div>
                </div>
                <div class="col-6 col-sm-6 col-lg-6 col-md-6">
                    <div class="card card-style">
                        <div class="content">
                            <div class=" py-1">
                                <div class="text-center align-self-center">
                                    <span class="icon rounded-s me-2 gradient-orange shadow-bg shadow-bg-s"><i class="bi bi-google color-white"></i></span>
                                </div>
                                <div class="text-center align-self-center ps-1">
                                    <h5 class="pt-1 mb-n1">Packages</h5>

                                    <p class="mb-0 font-11 opacity-50">Active Packages</p>
                                </div>
                                <h5 class="text-center pt-1 mb-n1">@if(Auth::user()->currentplan==0) not active @else
                                <marquee>
                                    @foreach(userHelper::getDailyROI(Auth::user()->ownid) as $rc)
                                    {{'$'.$rc->name}}&nbsp;
                                    @endforeach
                                </marquee>
                                @endif</h5>
                            </div>



                        </div>
                    </div>
                </div>
            </div>
            <div class="card card-style">
                <div class="content">
                    <div class=" py-1">

                        <div class="text-center align-self-center ps-1">
                            <h5 class="pt-1 mb-n1" style="font-size: 20px;">Join to be a Millionaire</h5>

                            <p class="mb-0 font-11 opacity-50">Use cloud mining and Defi technology to ensure that all user get the most TRX revenue.</p>
                        </div>
                        <div class="text-center align-self-center">
                            <img alt=".." src="{{asset('web')}}/images/pictures/criptoimg.png" style="width: 100%;" />
                        </div>
                    </div>



                </div>
            </div>



            <div class="content d-none">
                <div class="align-self-center">
                    <h5 class="color-black text-center font-700 mb-0 mt-0 pt-1" style="font-size: 20px;">
                        Platform data display
                    </h5>
                </div>

            </div>
            <div class="d-flex d-none">

                <div class="col-6 col-sm-6 col-lg-6 col-md-6">
                    <div class="card card-style">
                        <div class="content">
                            <div class=" py-1">
                                <div class="text-center align-self-center">
                                    <span class="icon rounded-s me-2 gradient-blue shadow-bg shadow-bg-s"><i class="bi bi-wallet color-white"></i></span>
                                </div>
                                <div class="text-center align-self-center ps-1">
                                    <p class="mb-0 font-11 opacity-50">Accmulated Profile</p>
                                </div>
                                <h5 class="text-center pt-1 mb-n1">{{$totalUsers}} </h5>

                            </div>



                        </div>
                    </div>
                </div>
                <div class="col-6 col-sm-6 col-lg-6 col-md-6">
                    <div class="card card-style">
                        <div class="content">
                            <div class=" py-1">
                                <div class="text-center align-self-center">
                                    <span class="icon rounded-s me-2 gradient-orange shadow-bg shadow-bg-s"><i class="bi bi-google color-white"></i></span>
                                </div>
                                <div class="text-center align-self-center ps-1">

                                    <p class="mb-0 font-11 opacity-50">Membership</p>
                                </div>
                                <h5 class="text-center pt-1 mb-n1">{{$activeUsers}}</h5>
                            </div>



                        </div>
                    </div>
                </div>
            </div>
            <div class="card card-style">
                <div class="content">
                    <div class=" py-1">

                        <div class="text-center align-self-center ps-1">
                            <h5 class="pt-1 pb-3 mb-n1" style="font-size: 20px;">About us</h5>

                            <p class="mb-0 font-11 opacity-50">cloud mining offered a potentially cost-effective way of mining for Bitcoins Trx and other cryptocurrencies.</p>
                        </div>
                        <div class="text-center align-self-center">
                            <img alt=".." src="{{asset('web')}}/images/pictures/criptoimg.png" style="width: 100%;" />
                        </div>
                    </div>



                </div>
            </div>
            <div class="card card-style">
                <div class="content">
                    <div class=" py-1">
                        <div class="row">
                            <div class="col-12" style="text-align: center;color: black;font-size: 12px;font-weight: 900;">
                                If you have no crypto account please click here 
                            </div>
                            @foreach(userHelper::getPlatforms() as $rc)
                            <div class="col-4 col-md-4 col-lg-4">
                                <a href="{{$rc->title}}" target="_blank">
                                <img alt=".." src="{{asset('Achievers')}}/{{$rc->image}}" style="width: 100%;" />
                                </a>
                            </div>
                            @endforeach
                        </div>

                    </div>



                </div>
            </div>




@endsection

