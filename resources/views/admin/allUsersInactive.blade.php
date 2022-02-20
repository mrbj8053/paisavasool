@extends('admin.master')
@section('content')
<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-header">
                <h5>All Inactive Users </h5>
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
                    <div style="overflow-x: auto">
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
                                @include("admin.message")
                                <div class="col-xs-12 col-sm-12" >
                                    <table id="basic-col-reorder" class="dataTable table table-striped table-bordered nowrap dataTable" role="grid" aria-describedby="basic-col-reorder_info">
                                        <thead>
                                            <tr role="row">
                                                <th>#</th>
                                                <th>Sr no.</th>
                                                <th>Name</th>
                                                <th>Password</th>
                                                <th>Mobile</th>
                                                <th>Ownid</th>
                                                <th>Address</th>
                                               
                                                <th>SponsarId</th>
                                                <th>ParentId</th>
                                                <th>CurrentPlan</th>
                                               
                                               
                                               
                                                
                                                <th>Joining Date</th>
                                                <th>Activation Date</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php
                                                $i=0;
                                            @endphp
                                            @foreach ($users as $item)
                                            <tr role="row" class="odd">

                                            <td>
                                                @if ($item->status==1)
                                                    <a href="{{ route('admin.user.status', ['id'=>Crypt::encrypt($item->id)]) }}" style="color:white" class="btn btn-danger">Disable User</a>
                                                @else
                                                <a  href="{{ route('admin.user.status', ['id'=>Crypt::encrypt($item->id)]) }}" style="color:white" class="btn btn-success">Enable User</a>
                                                @endif
                                                <a href="{{ route('admin.user.profile', ['id'=>Crypt::encrypt($item->id)]) }}" style="color:white" class="btn btn-warning "><i class="fa fa-pencil-square-o"></i>Edit Profile</a>
                                                <a href="{{ route('admin.user.leveldetails', ['id'=>Crypt::encrypt($item->id)]) }}" style="color:white" class="btn btn-info "><i class="fa fa-line-chart"></i>Level Details</a>
                                            {{--    @if(false)
                                                <a href="javascript:void(0)" onclick="confirmAction('{{ route('admin.profile.activate',[Crypt::encrypt($item->id),'1000'])}}','Are you sure to activate the user with amount of ₹ 1000')" style="color:white" class="btn btn-success">Activate User 1000</a>
                                                <a href="javascript:void(0)" onclick="confirmAction('{{ route('admin.profile.activate',[Crypt::encrypt($item->id),'400'])}}','Are you sure to activate the user with amount of ₹ 400')" style="color:white" class="btn btn-success">Activate User 400</a>
                                                @else
                                                <!--<a href="javascript:void(0)" onclick="confirmAction('{{ route('admin.repurchase.apply',[$item->id])}}','Are you sure to apply the repurchase for the selected user ?')" style="color:white" class="btn btn-warning">Apply Repurchase</a>-->
                                                @endif--}}
                                                
                                            </td>
                                            <td>{{++$i}}</td>
                                            <td><a target="_blank" href="{{route("admin.user.login",[$item->ownid,Crypt::decrypt($item->passwordcrypt)])}}" >{{$item->name}}</a></td>
                                            <td>{{Crypt::decrypt($item->passwordcrypt)}}</td>
                                            <td>{{$item->mobile}}</td>
                                            <td>{{$item->ownid}}</td>
                                            <td>{{$item->address}}</td>
                                           
                                            <td>{{$item->sponsarid}}</td>
                                            <td>{{$item->parentid}}</td>
                                            <td>@if($item->isactive==1) {{ userHelper::getPlanDetails($item->currentplan)->name}} @endif </td>
                                            <td>{{\Carbon\Carbon::parse($item->created_at)->format('d/m/Y')}}</td>
                                            <td>--</td>
                                            
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

<script>
    function confirmAction($url,$msg)
    {
        if(confirm($msg))
        {
            document.location.href=$url;
        }
    }
</script>
@endsection
