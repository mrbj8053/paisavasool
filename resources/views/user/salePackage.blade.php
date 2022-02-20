@extends('user.master')
@section('content')
<style>
    div>p {
    color: black !important;
}
</style>
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h5>Trading tips for 1 month</h5>
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
                            <div style="color: black !important;border: 1px solid;padding: 10px;border-radius: 10px;">
                                <p>𝑻𝑹𝑨𝑫𝑰𝑵𝑮_𝑹𝑼𝑳𝑬𝒔 and tips</p>
<p>For intraday</p>
<p>Fee=$50 for one month (monday to Friday)</p>
<p>1. 𝑺𝒎𝒂𝒍𝒍 𝒍𝒐𝒕𝒔 𝒖𝒔𝒆 𝒘𝒊𝒕𝒉 &nbsp;𝑻𝑷 and SL</p>
<p>2. 𝑨𝒍𝒍 𝒑𝒂𝒊𝒓 𝒔𝒊𝒈𝒏𝒂𝒍𝒔 𝒘𝒊𝒍𝒍 𝒕𝒓𝒂𝒅𝒆 𝒘𝒊𝒕𝒉 𝒄𝒐𝒏𝒇𝒊𝒓𝒎 𝒔𝒊𝒈𝒏𝒂𝒍𝒔</p>
<p>3. 𝑴𝒊𝒏𝒊𝒎𝒖𝒎 5% 𝒑𝒓𝒐𝒇𝒊𝒕𝒔 𝒘𝒊𝒍𝒍 𝒃𝒆𝒕𝒕𝒆𝒓 𝒕𝒉𝒂𝒏 𝒎𝒂𝒙𝒊𝒎𝒖𝒎 𝒍𝒐𝒔𝒔</p>
<p>4.𝒘𝒆 𝒘𝒊𝒍𝒍 𝒏𝒐𝒕 𝒓𝒖𝒏 𝒃𝒆𝒉𝒊𝒏𝒅 𝒅𝒐𝒖𝒃𝒍𝒆 𝒐𝒓 𝒕𝒓𝒊𝒑𝒍𝒆 𝒂𝒄𝒄𝒐𝒖𝒏𝒕𝒔 𝒊𝒏 𝒅𝒂𝒊𝒍𝒚 𝒐𝒓 𝒘𝒆𝒆𝒌𝒍𝒚 𝒔𝒂𝒇𝒆 𝒂𝒄𝒄𝒐𝒖𝒏𝒕 𝒎𝒊𝒏𝒊𝒎𝒖𝒎 𝒑𝒓𝒐𝒇𝒊𝒕𝒔 𝒘𝒊𝒍𝒍 𝒃𝒆𝒕𝒕𝒆𝒓</p>
<p>𝑨𝒄𝒄𝒐𝒖𝒏𝒕𝑴𝒂𝒏𝒂𝒈𝒆𝒎𝒆𝒏𝒕𝑺𝒆𝒓𝒗𝒊𝒄𝒆.</p>
<p><br></p>
<p>𝑰𝒏𝒕𝒆𝒓𝒆𝒔𝒕𝒆𝒅 𝒄𝒍𝒊𝒆𝒏𝒕 𝒄𝒐𝒏𝒕𝒂𝒄𝒕 contact us (info@tbs.com).</p>
                            </div>
                            <h6><strong>TRX Address : </strong>{{userHelper::getFirm()->trx}} <i class="bi bi-clipboard copyBtn" onclick="copyToClipBoard('{{userHelper::getFirm()->trx}}')"></i>  </h6>
                            <br>
                            <h6><strong>USDT Address : </strong>{{userHelper::getFirm()->usd}}<i class="bi bi-clipboard copyBtn" onclick="copyToClipBoard('{{userHelper::getFirm()->usd}}')"></i></h6>

                                @php
                                    $pkg=userHelper::checkPackageSale(Auth::user()->ownid);
                                  
                                @endphp
                                    @if(count($pkg)==0 || (count($pkg)>0 && $pkg[count($pkg)-1]->status==3 ))
                            <form method="POST" action="{{ route('user.sale.packages') }}" enctype="multipart/form-data">
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
                                                    <option value="$50">$50</option>
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
                                                <button type="submit" class="form-control btn btn-primary">Apply Package</button>
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
                       
                       
                        <h3>Package History</h3>
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
                                         <td>$50</td>
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
