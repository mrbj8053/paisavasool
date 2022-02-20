@extends('user.master')
@section('content')
<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-header">
                <h5>Request E-Pin</h5>
                <hr>
                <span><!-- lorem ipsum dolor sit amet, consectetur adipisicing elit --></span>
                <div class="card-header-right">
                    <ul class="list-unstyled card-option">
                        <li><i class="feather icon-maximize full-card"></i></li>
                        <li><i class="feather icon-minus minimize-card"></i></li>
                        <li><i class="feather icon-trash-2 close-card"></i></li>
                    </ul>
                </div>
            </div>
            <div>
                <div class="card-block">
                    @include('user.message')
                    <b style="background:yellow;padding:5px;font-size: medium">Amount will Be deducted from your Pending Withdraw i.e. = {{round($with,2)}}</b>
                    <hr>
                    <p style="color: black;font-weight:600">Request E-Pins</p>
                    <form action="{{ route('user.epin.request') }}" method="POST">
                    @csrf
                    <div class="row pt-3 ml-auto">
                    <div class="form-group col-lg-4">
                    <input type="number" name="number" value="{{old('number')}}" class="form-control form-txt-primary @error('number') is-invalid @enderror" placeholder="Number of E-Pins">
                    @error('number')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                    </div>
                    <div class="form-group col-lg-4">
                        <select class="form-control form-txt-primary @error('package') is-invalid @enderror"  name="package" id="package">
                                <option value="">--Select Package--</option>
                                @foreach ($plans as $item)
                        <option value="{{Crypt::encrypt($item->id)}}">{{$item->name}}</option>
                                @endforeach
                        </select>
                        @error('package')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    
                    <div class="form-group col-lg-4">
                        <button type="submit" class="btn btn-primary m-b-0">Request</button>
                    </div>
                    </div>
                </form>
                    <div class="dt-responsive table-responsive">
                        <div id="basic-col-reorder_wrapper" class="dataTables_wrapper dt-bootstrap4">
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-sm-12 col-md-6">
                                    <div class="dataTables_length" id="basic-col-reorder_length"></div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-6">
                                    <div id="basic-col-reorder_filter" class="dataTables_filter"></div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-12 col-sm-12">
                                    <table id="basic-col-reorder" class="table table-striped table-bordered nowrap dataTable" role="grid" aria-describedby="basic-col-reorder_info">
                                        <thead>
                                            <tr role="row">
                                                <th>Sr no.</th>
                                                <th>Quantity</th>
                                                <th>Amount</th>
                                                <th>Package Type</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php
                                                $i=0;
                                            @endphp
                                            @foreach ($epins as $item)
                                            <tr role="row" class="odd">
                                            <td>{{++$i}}</td>
                                            <td>{{$item->number}}</td>
                                            <td>{{$item->amount}}</td>
                                            <td>{{userHelper::getPlanDetails($item->planid)->name}}</td>
                                            <td>@if ($item->status==0)
                                                Pending
                                                @elseif($item->status==1)
                                                Approoved
                                                @else
                                                Request Canceled
                                            @endif</td>
                                            @endforeach
                                            </tr>
                                        </tbody>

                                    </table>
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
