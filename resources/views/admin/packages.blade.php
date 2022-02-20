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
                    @include('admin.message')
                   
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
                                <div class="col-xs-12 col-sm-12" style="width:100%;overflow-x:auto">
                                    <table id="basic-col-reorder" class="table table-striped table-bordered dataTable" role="grid" aria-describedby="basic-col-reorder_info">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Status</th>
                                                <th>Package Name</th>
                                                <th>User Name </th>
                                                <th>User ID</th>
                                                <th>Mobile</th>
                                                <th>Transacation ID</th>
                                                <th>Payment Mode</th>
                                                <th>Screenshot</th>
                                                <th>Requested On</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php
                                                $i=0;
                                            @endphp
                                            @foreach ($record as $item)
                                            <tr>
                                            <td >{{++$i}}</td>
                                            <td>
                                                @if($item->status==0)
                                                    <a href="javascript:void(0)" class="btn btn-warning" onclick="confirmRedirect('{{route('admin.package.apply',Crypt::encrypt($item->id))}}')">Apply Now</a>
                                                    <a href="javascript:void(0)" class="btn btn-danger" onclick="confirmDelete('{{route('admin.package.delete',Crypt::encrypt($item->id))}}')">Delete Request</a>
                                                @else
                                                    <p class="label label-success">Package applied on {{\Carbon\Carbon::parse($item->updated_at)->format("d/m/Y")}}</p>
                                                @endif
                                            </td>
                                            <td>{{$item->name}}</td>
                                            <td>{{$item->userName }}</td>
                                            <td>{{$item->ownid}}</td>
                                            <td>{{$item->mobile}}</td>
                                            <td>{{$item->txnid}}</td>
                                            <td>{{$item->pmode}}</td>
                                            <td><a href="{{asset("screenshot"."/".$item->image)}}" target="_blank"><img src="{{asset("screenshot"."/".$item->image)}}" style="width:200px;" alt=""/></a></td>
                                            <td>{{\Carbon\Carbon::parse($item->created_at)->format("d/m/Y")}}</td>
                                            
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
    function confirmRedirect($url)
    {
        if(confirm("Are you sure apply the package ?"))
        {
            document.location.href=$url;
        }
       
    }
    function confirmDelete($url)
    {
        if(confirm("Are you sure to delete this package request ?"))
        {
            document.location.href=$url;
        }
    }
</script>
@endsection
