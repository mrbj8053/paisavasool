@extends('user.master')
@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h5>Trading Package</h5>
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
                            <h6><strong>TRX Address : </strong>{{userHelper::getFirm()->trx}} <i class="bi bi-clipboard copyBtn" onclick="copyToClipBoard('{{userHelper::getFirm()->trx}}')"></i>  </h6>
                            <br>
                            <h6><strong>USDT Address : </strong>{{userHelper::getFirm()->usd}}<i class="bi bi-clipboard copyBtn" onclick="copyToClipBoard('{{userHelper::getFirm()->usd}}')"></i></h6>

                                @php
                                    $pkg=userHelper::checkPackage(Auth::user()->ownid);
                                  
                                @endphp
                                    @if(count($pkg)==0 || (count($pkg)>0 && $pkg[count($pkg)-1]->status==1 ))
                            <form method="POST" action="{{ route('user.trading.packages') }}" enctype="multipart/form-data">
                                @csrf
                                <!-- Address -->
                                <div class="pl-lg-12">
                                    <div class="row">
                                        <div class="col-lg-4 col-xs-12 col-md-12 col-sm-12">
                                            <div class="form-group">
                                                <label class="form-control-label">Select Package Amount</label>
                                                <select style="width:100%" class=" form-control"
                                                name="package"  required id="package">
                                                    <option value="">Select package amount</option>
                                                    @foreach (userHelper::getPlans() as $item)
                                                    <option value="{{$item->id}}">{{$item->name}}</option>
                                                    @endforeach
                                                </select>
                                                @error('package')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label class="form-control-label" for="input-city">Transaction ID</label>
                                                <input value="{{ old("txnid") }}" type="text"
                                                    class="form-control  @error('txnid') is-invalid @enderror"
                                                     name="txnid"  required  placeholder="Enter Transaction ID ">
                                                @error('txnid')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label class="form-control-label" for="input-city">Select Payment Mode</label>
                                                <select  style="width:100%" class="form-control"
                                                name="paymentmode"  required id="paymentmode">
                                                    <option value="">Select payment mode</option>
                                                    <option value="trx">TRX</option>
                                                    <option value="usdt">USDT</option>
                                                </select>
                                                @error('paymentmode')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label class="form-control-label" for="screenshot">Upload Screenshot</label>
                                                <input value="{{ old("screenshot") }}" type="file"
                                                    class="form-control  @error('screenshot') is-invalid @enderror"
                                                     name="screenshot"  required  placeholder="Upload Screenshot ">
                                                @error('screenshot')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-lg-4 ">
                                            <div class="form-group">
                                                <br>
                                                <button type="submit" class="form-control btn btn-primary">Apply</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                        </div>
                        </form>
                        @endif
                        @php 
                        $i=0;
                        @endphp
                       @if(count($pkg)>0)
                       
                       
                        <h3>All Packages</h3>
                      <div style="width:100%;overflow-x:auto">
                        <table class="table table-striped table-bordered nowrap dataTable">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Package Name</th>
                                <th>Transaction ID</th>
                                <th>Payment Mode</th>
                                <th>Screen Shot</th>
                                <th>Package Status</th>
                                </tr>
                                </thead>
                                <tbody>
                                     @foreach($pkg as $rc)
                                     <tr>
                                         <td>{{++$i}}</td>
                                         <td>{{ userHelper::getPlanDetails($rc->planid)->name}}</td>
                                         <td>{{$rc->txnid}}</td>
                                         <td>{{ strtoupper($rc->pmode)}}</td>
                                         <td><a href="{{asset("screenshot"."/".$rc->image)}}" target="_blank"><img src="{{asset("screenshot"."/".$rc->image)}}" style="width:200px"/></a></td>
                                         <td>@if ($rc->status==0)
                                    <p class="label label-danger">Request under review</p>
                                    @else
                                    <p class="label label-success">Package applied successfully on {{\Carbon\Carbon::parse($rc->updated_at)->format("d-m-Y")}}</p>
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
    </div>
    </div>
@endsection
