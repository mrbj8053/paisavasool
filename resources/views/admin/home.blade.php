@extends('admin.master')
@section('content')
<style>
    .black_gradient{
        background: linear-gradient(45deg, #629f12, #00000094);
    }
</style>
<script>
    function applyWithdraw($url)
    {
        if(confirm('Are you sure to apply withdraw ?'))
        {
           document.location.href=$url;
        }
        else
        {
            alert("Withdraw Cancelled")
        }
    }
</script>
<div class="row">
    <div class="container card p-2">
        <form method="POST" action="{{ route('admin.filter') }}">
            @csrf
            @include('admin.message')
            <div class="row ">

                    <div class="col-md-12 col-xl-3">
                        <div class="form-group">
                            <label class="form-control-label" style="color: black" for="input-username">From Date </label>
                            <input type="date" name="fromdate" class="form-control"  required >
                        </div>
                    </div>
                    <div class="col-md-12 col-xl-3">
                        <div class="form-group">
                            <label class="form-control-label" style="color: black" for="input-username">To Date</label>
                            <input type="date" name="todate"
                              class="form-control"  required >
                        </div>
                    </div>
                         <div class="col-md-3 col-xl-3">
                        <div class="form-group">
                            <button type="submit" name="submit" style="margin-top: 30px" class="btn btn-success">Filter By Date</button>

                        <a href="javascript:void(0)" STYLE="display:none" onclick="applyWithdraw('{{route('admin.withdraw.apply')}}')" class="btn btn-warning mt-2">Apply Withdraw</a>
                        </div>

                    </div>
                    <div class="col-lg-12">
                        @if (Session::has('adminfrom') && Session::has('adminto'))
                    <label class="form-control-label" style="color: black" for="input-username">Showing Records From : <span style="color: green">{{ Session::get('adminfrom') }}</span>, To : <span style="color: red">{{ Session::get('adminto') }}</span></label>
                        <a style="margin:20px" href="{{ route('admin.filter.clear') }}" class="btn btn-warning">Show All</a>
                        @endif
                    </div>
                </div>
                </form>


            </div>
    <div class="col-lg-12 mb-4" >
            <h3>User Details</h3>
            <hr>
    </div>
    <div class="col-xl-3 col-md-6" style="margin-bottom: 12px;">
      <div class="card black_gradient text-white">
      <div class="card-block">
        <div class="col col-auto text-center" style="margin-top: -49px;">
            <i class="feather icon-user f-50 text-c-white" style="background: linear-gradient(45deg, #629f12, #00000094);
            border-radius: 37px;"></i>
        </div>
         <div class="row align-items-center">

        <div class="col">
            <p class="m-b-5">Total Users</p>
            <h4 class="m-b-0">{{count($users)}}</h4>
         </div>

        </div>
      </div>
       </div>
    </div>


    <div class="col-xl-3 col-md-6" style="margin-bottom: 12px;">
        <div class="card  text-white" style="background: linear-gradient(
            45deg, #435e1e, #0599175c);">
        <div class="card-block">
            <div class="col col-auto text-center" style="margin-top: -49px;">
                <i class="feather icon-user f-50 text-c-white" style="background: linear-gradient(45deg, #435e1e, #0599175c);
                border-radius: 37px;"></i>
               </div>
        <div class="row align-items-center">
        <div class="col">
        <p class="m-b-5">Users this week </p>
        <h4 class="m-b-0">{{count($usersthisweek)}}</h4>
        </div>

        </div>
        </div>
        </div>
        </div>
       <div class="col-xl-3 col-md-6" style="margin-bottom: 12px;">
        <div class="card  text-white" style="background: linear-gradient(
            45deg, #3c2c7e, #5c54666b);">
        <div class="card-block">
            <div class="col col-auto text-center" style="margin-top: -49px;">
                <i class="fa fa-inr f-50 text-c-white" style="background: linear-gradient(45deg, #3c2c7e, #5c54666b);
                border-radius: 37px;width: 58px;
                height: 58px;"></i>
                </div>
        <div class="row align-items-center">
        <div class="col">
        <p class="m-b-5">Company Business</p>
        <h4 class="m-b-0">{{ $business }}</h4>
        </div>

        </div>
        </div>
        </div>
        </div>
        <div class="col-xl-3 col-md-6" style="margin-bottom: 12px;">
        <div class="card black_gradient text-white">
        <div class="card-block">
            <div class="col col-auto text-center" style="margin-top: -49px;">
                <i class="fa fa-inr f-50 text-c-white" style="background: linear-gradient(45deg, #629f12, #00000094);
                border-radius: 37px;width: 58px;
                height: 58px;"></i>
                </div>
        <div class="row align-items-center">
        <div class="col">
        <p class="m-b-5">Company Today Business</p>
        <h4 class="m-b-0">{{ $todayBusiness }}</h4>
        </div>

        </div>
        </div>
        </div>
        </div>

    <div class="col-lg-12 mb-4">
        <h3>Income Details</h3>
        <hr>
    </div>

    <div class="col-xl-3 col-md-6 " style="margin-bottom: 12px;">
    <div class="card black_gradient text-white">
    <div class="card-block">
        <div class="col col-auto text-center" style="margin-top: -49px;">
            <i class="fa fa-inr f-50 text-c-white" style="background: linear-gradient(45deg, #629f12, #00000094);
            border-radius: 37px;width: 58px;
            height: 58px;"></i>
            </div>
    <div class="row align-items-center">
        <div class="col">
        <a href="{{ route('admin.income',"Direct")}}" style="color:white">
    <p class="m-b-5">Direct Income</p>
        <h4 class="m-b-0">{{ round($directincome) }}</h4>
    </a>
    </div>

    </div>
    </div>
    </div>
    </div>
    <div class="col-xl-3 col-md-6" style="margin-bottom: 12px;">
    <div class="card bg-c-pink text-white">
    <div class="card-block">
        <div class="col col-auto text-center" style="margin-top: -49px;">
            <i class="fa fa-inr f-50 text-c-white" style="background: linear-gradient(to right, #fe5d70, #fe909d);
            border-radius: 37px;width: 58px;
            height: 58px;"></i>
            </div>
    <div class="row align-items-center">
        <div class="col">
        <a href="#!" style="color:white">
    <p class="m-b-5">Level Income</p>
        <h4 class="m-b-0">{{ round($levelincome)}}</h4>
    </a>
    </div>

    </div>
    </div>
    </div>
    </div>
    <div class="col-xl-3 col-md-6" style="margin-bottom: 12px;">
    <div class="card bg-c-green text-white">
    <div class="card-block">
        <div class="col col-auto text-center" style="margin-top: -49px;">
            <i class="fa fa-inr f-50 text-c-white" style="background: linear-gradient(to right, #0ac282, #0df3a3);
            border-radius: 37px;width: 58px;
            height: 58px;"></i>
            </div>
    <div class="row align-items-center">
    <div class="col">
    <p class="m-b-5">ROI Income</p>
    <h4 class="m-b-0">{{ round($roiincome) }}</h4>
    </div>

    </div>
    </div>
    </div>
    </div>


    <div class="col-xl-3 col-md-6" style="margin-bottom: 12px;">
        <div class="card black_gradient text-white">
        <div class="card-block">
            <div class="col col-auto text-center" style="margin-top: -49px;">
                <i class="fa fa-inr f-50 text-c-white" style="background: linear-gradient(45deg, #629f12, #00000094);
                border-radius: 37px;width: 58px;
                height: 58px;"></i>
                </div>
        <div class="row align-items-center">
        <div class="col">
        <p class="m-b-5">Total Income</p>
        <h4 class="m-b-0">{{ round($directincome+$levelincome+$roiincome) }}</h4>
        </div>

        </div>
        </div>
        </div>
        </div>

        {{-- <div class="col-xl-3 col-md-6">
            <div class="card bg-c-blue text-white">
            <div class="card-block">
            <div class="row align-items-center">
            <div class="col">
            <p class="m-b-5">Withdraw Given</p>
            <h4 class="m-b-0">{{ round($withdraw) }}</h4>
            </div>
            <div class="col col-auto text-right">
            <i class="fa fa-inr f-50 text-c-white"></i>
            </div>
            </div>
            </div>
            </div>
            </div> --}}
    </div>
@endsection

