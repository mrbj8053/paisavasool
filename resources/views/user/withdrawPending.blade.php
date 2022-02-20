@extends('user.master')
@section('content')
<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-header">
                <h5>Withdraw Pending</h5>
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
                                                <th></th>
                                                <th>Sr no.</th>
                                                <th>Amount </th>
                                                <th>TDS(3.75%)</th>
                                                <th>Admin(5%)</th>
                                                <th>Net</th>
                                                <th>Date</th>
                                                
                                               
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php
                                                $i=0;
                                            @endphp
                                            @foreach ($record as $item)
                                            <tr role="row" class="odd">
                                                <td>
                                                    <a href="{{ route('user.withdraw.details', ['id'=>Crypt::encrypt($item->id)]) }}" class="btn btn-info">Show Details    <i class="fa fa-inr"></i></a>
                                                </td>
                                            <td>{{++$i}}</td>
                                            <td>{{$item->amount}}</td>
                                            <td>{{$item->tds}}</td>
                                            <td>{{$item->admin}}</td>
                                            <td>{{$item->net}}</td>
                                            <td>{{\Carbon\Carbon::parse($item->created_at)->format('d/m/yy')}}</td>
                                           
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
