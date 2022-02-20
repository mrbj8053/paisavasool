@extends('admin.master')
@section('content')
<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-header">
                <h5>{{$title}}</h5>
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
                                @include('admin.message')
                                <div class="col-xs-12 col-sm-12">
                                    <table id="basic-col-reorder" class="table table-striped table-bordered nowrap dataTable" role="grid" aria-describedby="basic-col-reorder_info">
                                        <thead>
                                            <tr role="row">
                                                <th>Sr no.</th>
                                                <th>From </th>
                                                <th>Name </th>
                                                <th>Level</th>
                                                <th>Date</th>
                                                <th>Plan</th>
                                                <th>Type</th>
                                                <th>Remark</th>
                                                <th>Amount</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php
                                                $i=0;
                                                $income2=0;
                                                $posted=0;
                                                $balance=0;
                                            @endphp
                                            @foreach ($income as $item)
                                            @php
                                            if($item->amount>0)
                                            $income2+=$item->amount;
                                            else
                                            $posted+=$item->amount;
                                            @endphp
                                            <tr role="row" class="odd">
                                            <td>{{++$i}}</td>
                                            <td>{{$item->fromuser}}</td>
                                            <td>{{$item->name}}</td>
                                            <td>{{$item->level}}</td>
                                            <td>{{\Carbon\Carbon::parse($item->created_at)->format('d/m/Y')}}</td>
                                            <td>{{$item->plan}}</td>
                                            <td>{{$item->incometype}}</td>
                                            <td>{{$item->remark}}</td>
                                            <td>{{ round($item->amount) }}</td>
                                            @endforeach
                                            </tr>
                                        </tbody>

                                    </table>
                                    
                                    <h2><strong>Income : </strong>{{$income2}}</h2>
                                    <h2><strong>Posted : </strong>{{$posted}}</h2>
                                    <h2><strong>Balance : </strong>{{$income2+$posted}}</h2>
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
