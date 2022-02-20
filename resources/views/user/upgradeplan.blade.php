@extends('user.master')
@section('content')
<style>
table, th, td {
    width: 100%;
  border: 1px solid black;
  padding:10px;
}
.bold {
    font-weight: 600;

}
    </style>
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h5>Upgrade My Plan</h5>
                    <hr>
                    <span>
                        <!-- lorem ipsum dolor sit amet, consectetur adipisicing elit --></span>
                    <div class="card-header-right">
                        <ul class="list-unstyled card-option">
                            <li><i class="feather icon-maximize full-card"></i></li>

                        </ul>
                    </div>
                </div>
                <div>

                    <div class="card-block">
                        @include('user.message')
                        <div class="card-body">
                           
                                <!-- Address -->
                                <div class="pl-lg-4">
                                    <div class="row">
                                        <div class="col-lg-3">
                                            @php
                                                $plan=userHelper::getPlanDetails(Auth::user()->currentplan);
                                            @endphp
                                                <label class="bold text-center" style="width:100%;background: blue;color: #ffffff;padding: 5px;border-radius: 8px;">Current Plan Details</label>
                                                <table>
                                                    <tr>
                                                        <td class="bold">Name :</td>
                                                        <td>{{$plan->name}}</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="bold">Upgrade At :</td>
                                                        <td>{{$plan->incomelimit}}</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="bold">Plan Amount:</td>
                                                        <td>{{$plan->entryamount}}</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="bold">Direct Income:</td>
                                                        <td>{{$plan->directincome}}</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="bold">Level Income:</td>
                                                        <td>{{$plan->levelincome}}</td>
                                                    </tr>
                                                    
                                                </table>
                                        </div>
                                        @if ($plan->id!=6)
                                        @php
                                            $planNext=userHelper::getPlanDetails(Auth::user()->currentplan+1);
                                        @endphp
                                        <div class="col-lg-3">
                                            <label class="bold text-center" style="width:100%;background: #0b9b0b;color: #ffffff;padding: 5px;border-radius: 8px;">Next Plan Details</label>
                                            <table>
                                                <tr>
                                                    <td class="bold">Name :</td>
                                                <td>{{$planNext->name}}</td>
                                                </tr>
                                                <tr>
                                                    <td class="bold">Upgrade At :</td>
                                                    <td>{{$planNext->incomelimit}}</td>
                                                </tr>
                                                <tr>
                                                    <td class="bold">Plan Amount:</td>
                                                    <td>{{$planNext->entryamount}}</td>
                                                </tr>
                                                <tr>
                                                    <td class="bold">Direct Income:</td>
                                                    <td>{{$planNext->directincome}}</td>
                                                </tr>
                                                <tr>
                                                    <td class="bold">Level Income:</td>
                                                    <td>{{$planNext->levelincome}}</td>
                                                </tr>
                                                
                                            </table>
                                    </div>
                                    @endif
                                    @if ((Auth::user()->directincome+Auth::user()->levelincome+Auth::user()->clubincome)>=$plan->incomelimit && $plan->id!=6)
                                    <div class="col-lg-12 pt-5">
                                        <form method="POST" action="{{ route('user.plan.upgrade') }}" enctype="multipart/form-data">
                                            @csrf
                                        <div class="col-lg-12 ">
                                            <div class="form-group" >
                                                <label class="form-control-label" for="input-city">Enter Plan Upgrade Pin</label>
                                                <input  type="text"
                                                    class="form-control  @error('upgradePin') is-invalid @enderror"
                                                    required="" name="upgradePin" minlength="10" maxlength="10" placeholder="Enter E-pin">
                                                @error('upgradePin')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-lg-12  text-right">
                                            <div class="form-group">
                                                <br>
                                                <button type="submit" class="btn btn-primary">Upgrade my plan</button>
                                            </div>
                                        </div>
                                    </form>
                                    </div>
                                    @else 
                                <h4 class="m-10">Your profile was not eligible for upgrade , your current total income is {{Auth::user()->directincome+Auth::user()->levelincome+Auth::user()->clubincome}} to upgrade you plan you have to achieve the target of income {{$plan->incomelimit}}</h4>

                                    @endif
                                   
                                    </div>
                                </div>

                        </div>
                       
                    </div>


                </div>
            </div>
        </div>
    </div>
    </div>
@endsection
