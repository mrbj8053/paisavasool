@extends('admin.master')
@section('content')
<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-header">
                <h5>Company Business Detail for date </h5>
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
                                @include('admin.message')
                                <div class="col-xs-12 col-sm-12">
                                    <table id="basic-col-reorder" class="dataTable table table-striped ">
                                        <thead>
                                            <tr role="row">
                                                <th>Sr no.</th>
                                                <th>User Id </th>
                                                <th>User Name</th>
                                                <th>SponsarId</th>
                                                <th>Mobile</th>
                                                <th>Package</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php
                                                $i=0;
                                            @endphp
                                            @foreach ($record as $item)
                                            <tr role="row" class="odd">
                                            <td>{{++$i}}</td>
                                            <td>{{$item->ownid}}</td>
                                            <td>{{$item->name}}</td>
                                            <td>{{$item->sponsarid}}</td>
                                            <td>{{$item->mobile}}</td>
                                            <td>{{$item->entryamount}}</td>
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
