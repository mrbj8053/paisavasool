@extends('user.master')
@section('content')
<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-header">
                <h5>Withdraw Details</h5>
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
                                @include('user.message')
                                <div class="col-xs-12 col-sm-12">
                                    <table id="basic-col-reorder" class="table table-striped dataTable ">
                                        <thead>
                                            <tr role="row">
                                                <th>Sr no.</th>
                                                <th>User Id </th>
                                                <th>User Name </th>
                                                <th>Amount</th>
                                                <th>Income type</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php
                                            $i=0;
                                            @endphp
                                             @foreach ($record as $item)
                                             <tr role="row" class="odd">
                                                 <td>{{++$i}}</td>
                                                 <td>{{$item->touser}}</td>
                                                 <td>{{$item->name}}</td>
                                                 <td>{{round($item->amount,2)}}</td>
                                                 <td>{{$item->incometype}}</td>
                                             </tr>
 
                                             @endforeach
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
