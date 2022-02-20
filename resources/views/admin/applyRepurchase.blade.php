@extends('admin.master')
@section('content')
<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-header">
                <h5>Apply Repurchase</h5>
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
                    <p style="color: black;font-weight:600">Apply  Repurchase</p>
                    <form action="{{ route('admin.repurchase.apply') }}" method="POST">
                    @csrf
                    <div class="row pt-3 ml-auto">
                          <div class="form-group col-lg-4">
                        <select required name="userid" class="select2 form-control form-txt-primary @error('userid') is-invalid @enderror" >
                        <option value="" >Select User</option>
                        @php
                            $record=userHelper::getAllActiveUser();
                        @endphp
                        @foreach ($record as $item)
                        <option value="{{$item->id}}">{{$item->name." (".$item->ownid.")"}}</option>
                        @endforeach
                        </select>
                        @error('userid')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                        </div>
                    <div class="form-group col-lg-4">
                    <input required type="number" name="amount" value="{{old('amount')}}" class="form-control form-txt-primary @error('amount') is-invalid @enderror" placeholder="Amount of repurchase">
                    @error('amount')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                    </div>
                  
                         <div class="form-group col-lg-4">
                            <input required type="text" name="narration" value="{{old('narration')}}" class="form-control form-txt-primary @error('narration') is-invalid @enderror" placeholder="Narration">
                            @error('narration')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                            </div>
                    <div class="form-group col-lg-4">
                        <button type="submit" class="btn btn-primary m-b-0">Apply Now</button>
                    </div>
                    </div>
                </form>
                <hr>

                   
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
                                                <th>User Name</th>
                                                <th>Amount</th>
                                                <th>Narration</th>
                                                <th>Date</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php
                                                $i=0;
                                            @endphp
                                            @foreach (userHelper::getRepruchase() as $item)
                                            <tr>
                                            <td >{{++$i}}</td>
                                            <td>{{$item->name." (".$item->ownid.")"}}</td>
                                            <td>{{$item->amount}}
                                            <td>{{$item->narration}}
                                            <td>{{\Carbon\Carbon::parse($item->created_at)->format("d/m/Y")}}
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

@endsection
