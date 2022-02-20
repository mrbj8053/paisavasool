@extends('admin.master')
@section('content')
<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-header">
                <h5>E-Pin Requests</h5>
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

            <hr>
            <div>

                <div class="card-block">
                    <div class="">
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
                                <div class="col-xs-12 col-sm-12" style="overflow-x: auto">
                                    @include('admin.message')
                                    <table id="basic-col-reorder" class="table table-striped table-bordered nowrap dataTable" role="grid" aria-describedby="basic-col-reorder_info">
                                        <thead>
                                            <tr role="row">
                                                <th>Sr no.</th>
                                                <th>User ID</th>
                                                <th>User Name</th>
                                                <th>Quantity</th>
                                                <th>Amount</th>
                                                <th>Package Type</th>
                                                <th>Date</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php
                                                $i=0;
                                            @endphp
                                           @foreach ($epins as $item)
                                           @php
                                               $user=userHelper::getUserById($item->fuserid);
                                           @endphp
                                           <tr role="row" class="odd">
                                           <td>{{++$i}}</td>
                                           <td>{{ $user->ownid}}</td>
                                           <td>{{ $user->name}}</td>
                                           <td>{{$item->number}}</td>
                                           <td>{{$item->amount}}</td>
                                           <td>{{userHelper::getPlanDetails($item->planid)->name}}</td>
                                           <td>{{\Carbon\Carbon::parse($item->amount)->format('d/m/Y')}}</td>
                                           <td>@if ($item->status==0)
                                               <a href="{{ route('admin.epin.request.accept', ['id'=>Crypt::encrypt($item->id)]) }}" class="btn btn-primary">Aproove Request</a>
                                               <a href="{{ route('admin.epin.request.decline', ['id'=>Crypt::encrypt($item->id)]) }}" class="btn btn-danger">Decline Request</a>
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
