@extends('user.master')
@section('content')
<style>
 .invalid-feedback {
    display: block;
    width: 100%;
    margin-top: 0.25rem;
    font-size: .875em;
    color: #dc3545;
}
    .form-custom>span{
    color:black;
    font-weight:600;
}
label.form-label-always-active.color-highlight.font-11 {
    background-color: white !important;
}
</style>
<script>
    function fetchBalance(type)
    {
        document.location.href='{{route('user.withdraw.apply')}}'+'/'+type;
    }
</script>
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

<div class="card card-style">
                <div class="content">
                    <div class=" py-1">

                        <div class=" align-self-center ps-1">
                            <div class="align-self-center">
                                <p class="mb-0 text-center">{{$type}} account balance</p>
                                <h1 class="mb-0 text-center" style="font-size: 29px;"><strong>$ {{$balance}}</strong></h1>
                            </div>
                            <div class="d-flex mx-3 mt-3 py-1">
                                <div class="align-self-center">
                                    <p class="mb-0 text-center">Minimum withdraw limit:10$</p>
                                </div>
                            </div>
                            <div class="divider divider-margins mt-3 "></div>
                              @include('user.message')
                            <div class="content mt-0 ">
                                <form method="POST" action="{{route('user.withdraw.apply.final')}}">
                                    @csrf
                                <div class="form-custom form-label form-icon ">
                                    <i class="bi bi-wallet2 font-14 "></i>
                                    <select required class="form-select rounded-xs @error('type') is-invalid @enderror" id="type" name="type" onchange="fetchBalance(this.value)" aria-label="Floating label select example ">
                                <option  @if($type=='Basic') selected  @endif value='Basic'>Basic account</option>
                                <option @if($type!='Basic') selected  @endif value="Promotion">Promotion account</option>
                                </select>
                                     
                                    <label for="c6 " class="form-label-always-active color-highlight font-11 ">Choose Account</label>
                                </div>
                                  @error('type')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                <div class="pb-3 "></div>
                                <div class="form-custom form-label form-icon ">
                                    <i class="bi bi-code-square font-14 "></i>
                                    <input type="number " required  name="mobile" id="mobile" class="form-control rounded-xs @error('mobile') is-invalid @enderror" id="c3 " placeholder="Mobile" readonly value="{{Auth::user()->mobile}}">
                                     
                                    <label for="mobile " class="form-label-always-active color-highlight font-11 ">Mobile</label>
                                    <span class="font-10 ">(required)</span>
                                </div>
                                @error('mobile')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                 <div class="form-custom form-label form-icon ">
                                    <i class="bi bi-code-square font-14 "></i>
                                    <input type="number " required  name="amount" id="amount" class="form-control rounded-xs @error('amount') is-invalid @enderror" id="c3 " placeholder="Enter amount" value="{{old('amount')}}" >
                                    
                                    <label for="mobile " class="form-label-always-active color-highlight font-11 ">Enter Amount</label>
                                    <span class="font-10 ">(required)</span>
                                </div>
                                 @error('amount')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                <div class="pb-3 "></div>
                                  <div class="form-custom form-label form-icon ">
                                    <i class="bi bi-wallet2 font-14 "></i>
                                    <select required class="form-select rounded-xs @error('addressType') is-invalid @enderror" id="addressType" name="addressType"  aria-label="Floating label select example ">
                                <option  selected  value='TRX'>TRX</option>
                                <option   value="USDT">USDT</option>
                                </select>
                                     
                                    <label for="c6 " class="form-label-always-active color-highlight font-11 ">Choose Crypto Currency </label>
                                </div>
                                  @error('addressType')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                <div class="pb-3 "></div>
                                <div class="form-custom form-label form-icon ">
                                    <i class="bi bi-code-square font-14 "></i>
                                    <input type="number " required id="address" name="address" class="form-control rounded-xs @error('address') is-invalid @enderror" value="{{old('address')}}" placeholder="Enter Crypto address">
                                     
                                    <label for="c4 " class="form-label-always-active color-highlight font-11 ">Crypto Address</label>
                                    
                                </div>
                                @error('address')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                <div class="pb-2 "></div>
                                <div class="form-custom form-label form-icon ">
                                    <i class="bi bi-exclamation-triangle font-14 "></i>
                                    <input type="text" required class="form-control rounded-xs @error('txnPassword') is-invalid @enderror" id="txnPassword " name="txnPassword" placeholder="Enter your transaction Password">
                                  
                                    <label for="txnPassword" class="form-label-always-active color-highlight font-11 ">Transaction Password</label>
                                </div>
                                  @error('txnPassword')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                
                            </div>
                            <div class="text-center">
                            <input type="submit"  class="mx-3 mb-3 btn gradient-green shadow-bg shadow-bg-s " value="Apply Withdraw">
                            </div>
</form>
                    @php 
                    $fetch=userHelper::getWithdraw(Auth::user()->ownid);
                    $total=$fetch["total"];
                    $with=$fetch["record"];
                        $i=0;
                        @endphp
                       @if(count($with)>0)
                       
                       
                        <h3>All Withdraw</h3>
                        <h5>Total withdraw : $ {{$total}}</h5>
                      <div style="width:100%;overflow-x:auto">
                        <table class="table table-striped table-bordered nowrap dataTable">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Amount</th>
                                <th>Applied On</th>
                                <th>Crypto Address Type</th>
                                <th>Crypto Address</th>
                                <th>Type</th>
                                <th>Status</th>
                                </tr>
                                </thead>
                                <tbody>
                                     @foreach($with as $rc)
                                     <tr>
                                         <td>{{++$i}}</td>
                                         <td>{{ $rc->net}}</td>
                                         <td>{{ \Carbon\Carbon::parse($rc->created_at)->format("d-m-Y")}}</td>
                                         <td>{{$rc->addresstype}}</td>
                                         <td>{{$rc->address}}</td>
                                         <td>{{$rc->type}}</td>
                                       <td>@if ($rc->status==0)
                                                    <p class="btn btn-warning">Request under review</p>
                                                    @elseif($rc->status==1)
                                                    <p class="btn btn-success">Withdraw applied successfully on {{\Carbon\Carbon::parse($rc->approoved_at)->format("d-m-Y")}}</p>
                                                    @else
                                                    <p class="btn btn-danger">Withdraw Rejected</p>
                                                    @endif </td>
                                     </tr>
                                     @endforeach
                                    
                                </tbody>
                                
                        </table>
                        </div>
                        @endif
                        </div>

                    </div>



                </div>
            </div>
            @endsection    
