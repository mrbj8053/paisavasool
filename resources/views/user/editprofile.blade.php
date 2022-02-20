@extends('user.master')
@section('content')
<div class="card card-style overflow-visible mt-5">
                <div class="mt-n5"></div>
                <img src="{{asset('logo.png')}}" alt="img" width="180" class="mx-auto rounded-circle mt-n5 shadow-l">
                <h1 class="color-theme text-center font-30 pt-3 mb-0"><span>Total Balance :</span>
                    <span style="color: green;">{{$netIncome}}</span>
                </h1>
                <div class="row p-3" >
                    <div class="col-6 col-lg-6 col-md-6">
                      <a href="{{route('user.trading.packages')}}">
                        <div class="d-flex " style="margin-left: 32px;">
                            <div class="text-center align-self-center">
                                <span class="icon rounded-s me-2 gradient-blue shadow-bg shadow-bg-s"><i class="bi bi-wallet color-white"></i></span>
                            </div>
                            <div class="text-center align-self-center ps-1">
                                <h5 class="pt-1 mb-n1">Deposit</h5>
                            </div>
                        </div>
</a>
                    </div>
                    <div class="col-6 col-lg-6 col-md-6 ">
                    <a href="{{route('user.withdraw.apply')}}">
                        <div class="d-flex " style="margin-left: 32px;">
                            <div class="text-center align-self-center">
                                <span class="icon rounded-s me-2 gradient-blue shadow-bg shadow-bg-s"><i class="bi bi-wallet color-white"></i></span>
                            </div>
                            <div class="text-center align-self-center ps-1">
                                <h5 class="pt-1 mb-n1">Withdrawal</h5>
                            </div>
                        </div>
</a>
                    </div>
                    <div class="col-6 col-lg-6 col-md-6 mt-3">
                    <a href="{{route('user.changepass')}}">
                        <div class="d-flex " style="margin-left: 32px;">
                            <div class="text-center align-self-center">
                                <span class="icon rounded-s me-2 gradient-blue shadow-bg shadow-bg-s"><i class="bi bi-wallet color-white"></i></span>
                            </div>
                            <div class="text-center align-self-center ps-1">
                                <h5 class="pt-1 mb-n1">Change password</h5>
                            </div>
                        </div>
</a>
                    </div>
                    <div class="col-6 col-lg-6 col-md-6 mt-3">
                    <a href="{{route('user.changetxnpass')}}">
                        <div class="d-flex " style="margin-left: 32px;">
                            <div class="text-center align-self-center">
                                <span class="icon rounded-s me-2 gradient-blue shadow-bg shadow-bg-s"><i class="bi bi-wallet color-white"></i></span>
                            </div>
                            <div class="text-center align-self-center ps-1">
                                <h5 class="pt-1 mb-n1">Change Txn Password</h5>
                            </div>
                        </div>
</a>
                    </div>
                </div>
            </div>




        </div>

@endsection