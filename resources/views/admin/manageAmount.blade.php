@extends('admin.master')
@section('content')
<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-header">
                <h5>Manage Amounts</h5>
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
                    @include('admin.message')
                    <p style="color: black;font-weight:600">Deduct or add amount in user account</p>
                    <form action="{{ route('admin.user.amount') }}" method="POST">
                    @csrf
                    <div class="row pt-3 ml-auto">
                    <div class="form-group col-lg-4">
                    <select required name="selectUser" class="form-control form-control-primary @error('selectUser') is-invalid @enderror">
                    <option value="">Select User</option>
                    @foreach ($users as $item)
                    <option value="{{Crypt::encrypt($item->id)}}">{{$item->name." (".$item->ownid.")"}}</option>
                    @endforeach
                    </select>
                    @error('selectUser')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                    </div>
                    <div class="form-group col-lg-4">
                        <select required name="amounttype" id="amounttype" class="form-control" >
                            <option value="">Select amount type</option>
                            <option value="0">Add</option>
                            <option value="1">Deduct</option>
                        </select>
                        @error('amounttype')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                        </div>
                    <div class="form-group col-lg-4">
                        <input type="number" name="amount" value="{{old('amount')}}" class="form-control form-txt-primary @error('amount') is-invalid @enderror" placeholder="Enter Amount">
                        @error('amount')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                        </div>
                    
                    <div class="form-group col-lg-4">
                        <button type="submit" class="btn btn-primary m-b-0">Submit</button>
                    </div>
                    </div>
                </form>
                    <div class="">
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
                                    <table id="basic-col-reorder" class="table table-striped table-bordered dataTable" role="grid" aria-describedby="basic-col-reorder_info">
                                        <thead>
                                            <tr>
                                                <th>Sr no.</th>
                                                <th>UserId</th>
                                                <th>Amount</th>
                                                <th>Type</th>
                                                <th>Date</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php
                                                $i=0;
                                            @endphp
                                            @foreach ($record as $item)
                                            <tr>
                                            <td >{{++$i}}</td>
                                            <td>{{$item->touser}}</td>
                                            <td>{{$item->amount}}</td>
                                            <td>{{$item->remark}}</td>
                                            <td>{{Carbon\Carbon::parse($item->created_at)->format('d/m/Y')}}</td>
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
<script>
    function copyToClipBoard($epin)
    {
        var input = document.createElement('input');
    input.setAttribute('value', $epin);
    document.body.appendChild(input);
    input.select();
    var result = document.execCommand('copy');
    document.body.removeChild(input);
    alert('Pin "'+$epin+'" copied to clipboard');
    }
</script>
@endsection
