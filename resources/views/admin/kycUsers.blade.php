@extends('admin.master')
@section('content')
<!-- Button trigger modal -->
<script>

    var angle = 0;
    

    function showImage(url)
    {
       angle = 0;
        $('#fullimg').attr("src",url);
        $('#btnFullImage').trigger('click');
        $("#fullimg").css('transform','rotate(0deg)');
        
        
    }
    function rotateCW()
    {
         angle +=90;
       $("#fullimg").css('transform','rotate('+angle+'deg)');
    }
    function rotateACW()
    {
         angle -= 90;
        $("#fullimg").css('transform','rotate('+angle+'deg)');
    }
</script>
<button style="display:none" id="btnFullImage" type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
  Launch demo modal
</button>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <img style="width:100%" id="fullimg" />
         <button type="button" class="btn btn-primary"  onclick="rotateACW()"><i class="fa fa-undo"></i></button>
        <button type="button" class="btn btn-primary"  onclick="rotateCW()"><i class="fa fa-repeat"></i></button>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      
      </div>
    </div>
  </div>
</div>
<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-header">
                <h5>{{$title}} </h5>
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
                                                <th></th>
                                                <th>Status</th>
                                                <th>Sr no.</th>
                                                <th>User ID</th>
                                                <th>User Name</th>
                                                <th>Account Number</th>
                                                <th>Pan Number </th>
                                                <th>Bank</th>
                                                <th>IFSC</th>
                                                <th>Branch</th>
                                                <th>Mobile</th>
                                                <th>Pan Image </th>
                                                <th>Adhar Front </th>
                                                <th>Adhar Back</th>
                                                <th>Passbook</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php
                                                $i=0;
                                            @endphp
                                            @foreach ($users as $u)
                                            <tr role="row" class="odd">
                                            <th>
                                                <a href="{{ route('admin.user.kyc.edit', ['id'=>Crypt::encrypt($u->id)]) }}" class="btn btn-warning">Edit   <i class="fa fa-pencil-square-o"></i></a>
                                                <a href="javascript:void(0)" onclick="confirmDeleteKYC('{{route("admin.kyc.delete",$u->id)}}')" class="btn btn-danger">Delete KYC  <i class="fa fa-trash"></i></a>
                                            </th>
                                            <td>
                                                @if ($u->kyc==1)
                                                <a href="{{ route('admin.user.kyc.status', ['id'=>Crypt::encrypt($u->id)]) }}" class="btn btn-success">Verify <i class="fa fa-check"></i></a>
                                                @elseif($u->kyc==0)
                                                    Kyc not uploaded
                                                @else
                                                    Kyc Verified
                                                @endif
                                                </td>
                                            <td>{{++$i}}</td>
                                            <td>{{$u->ownid}}</td>
                                            <td>{{$u->name}}</td>
                                            <td>{{$u->accountnumber}}</td>
                                            <td>{{$u->pannumber}}</td>
                                            <td>{{$u->bank}}</td>
                                            <td>{{$u->ifsc}}</td>
                                            <td>{{$u->branch}}</td>
                                            <td>{{$u->mobile}}</td>
                                            <td>
                                                <img src="{{ asset('kyc'.'/'.$u->panimage) }}" onclick="showImage('{{ asset('kyc'.'/'.$u->panimage) }}')"  style="width:200px;height:100px;cursor: pointer;"/>
                                            </td>
                                            <td>
                                                <img src="{{ asset('kyc'.'/'.$u->adharimage) }}" onclick="showImage('{{ asset('kyc'.'/'.$u->adharimage) }}')"  style="width:200px;height:100px;cursor: pointer;"/>
                                            </td>
                                            <td>
                                                <img src="{{ asset('kyc'.'/'.$u->adharbackimage) }}" onclick="showImage('{{ asset('kyc'.'/'.$u->adharbackimage) }}')"  style="width:200px;height:100px;cursor: pointer;"/>
                                            </td>
                                            <td>
                                                <img src="{{ asset('kyc'.'/'.$u->passbookimage) }}" onclick="showImage('{{ asset('kyc'.'/'.$u->passbookimage) }}')"   style="width:200px;height:100px;cursor: pointer;"/>
                                            </td>
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
