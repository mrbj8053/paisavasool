@extends('admin.master')
@section('content')
<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-header">
                <h5>Withdraw Requests</h5>
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
                                @include('admin.message')
                                <div class="col-xs-12 col-sm-12">
                                   
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <h2>Withdraw Requests</h2>
                                        </div>
                                        <div class="col-lg-12">
                                        <table class="dataTable table table-striped no-footer">
                                            <thead>
                                               <tr>
                                                <th>#</th>
                                                <th>Action</th>
                                                <th>Amount</th>
                                                <th>Applied On</th>
                                                <th>Address Type</th>
                                                <th>Address</th>
                                                <th>Type</th>
                                                <th>Status</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @php
                                                    $i=0;
                                                @endphp
                                                @foreach (userHelper::getWithdraw("admin","All")["record"] as $rc)
                                                <tr>
                                                    <td>{{++$i}}</td>
                                                    <td>
                                                        @if($rc->status==0)
                                                            <a href="javascript:void(0)" class="btn btn-warning" onclick="confirmRedirect('{{route('admin.withdraw.change',[Crypt::encrypt($rc->id),1])}}')">Apply Now</a>
                                                            <a href="javascript:void(0)" class="btn btn-danger" onclick="confirmDelete('{{route('admin.withdraw.change',[Crypt::encrypt($rc->id),2])}}')">Delete Request</a>
                                                        @else
                                                            <p class="label label-success">Package applied on {{\Carbon\Carbon::parse($item->updated_at)->format("d/m/Y")}}</p>
                                                        @endif
                                                    </td>
                                                    <td>{{ $rc->net}}</td>
                                                     <td>{{ \Carbon\Carbon::parse($rc->created_at)->format("d-m-Y")}}</td>
                                                      <td>{{$rc->addresstype}}</td>
                                                     <td>{{$rc->address}}</td>
                                                     <td>{{$rc->type}}</td>
                                                    <td>@if ($rc->status==0)
                                                    <p class="label label-danger">Request under review</p>
                                                    @elseif($rc->status==1)
                                                    <p class="label label-success">Withdraw applied successfully on {{\Carbon\Carbon::parse($rc->approoved_at)->format("d-m-Y")}}</p>
                                                    @else
                                                    <p class="label label-danger">Withdraw Rejected</p>
                                                    @endif </td>
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
    </div>
</div>
@endsection
<script>
    function confirmRedirect($url)
    {
        if(confirm("Are you sure apply the withdraw ?"))
        {
            document.location.href=$url;
        }
       
    }
    function confirmDelete($url)
    {
        if(confirm("Are you sure to delete this withdraw request ?"))
        {
            document.location.href=$url;
        }
    }
function isNumber(evt) {
    evt = (evt) ? evt : window.event;
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    if (charCode > 31 && (charCode < 48 || charCode > 57) && charCode!=46) {
        return false;
    }
    return true;
}
    </script>
