@extends('admin.master')
@section('content')
<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-header">
             
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
                   <h5>Showing closing details for date {{ \Carbon\Carbon::parse($closing->created_at)->format("d/m/Y")}}<br></h5>
                <div class="card-block">
                    <div class="dt-responsive table-responsive">
                        <div id="basic-col-reorder_wrapper" class="dataTables_wrapper dt-bootstrap4">
                           
                            <div class="row">
                                @include('admin.message')
                                <div class="col-xs-12 col-sm-12">
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <label for="plan1">Total ROI Payout</label>
                                                <input value="{{ round($roi) }}" readonly required class="form-control @error('plan1') is-invalid @enderror">
                                            </div>
                                            <div class="col-lg-6">
                                                <label for="plan2">Total Level Payout </label>
                                                <input value="{{ round($level)}}" readonly required class="form-control @error('plan2') is-invalid @enderror">
                                            </div>
                                             <div class="col-lg-6">
                                                <label for="plan2">Total Direct Payout </label>
                                                <input value="{{ round($direct)}}" readonly required class="form-control @error('plan2') is-invalid @enderror">
                                            </div>
                                            <div class="col-lg-6">
                                                <label for="plan3">Total Payout </label>
                                                <input value="{{round($level)+round($roi)+round($direct)}}" readonly required class="form-control @error('plan3') is-invalid @enderror">
                                            </div>
                                           

                                        </div>
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <h2>Full Details</h2>
                                        </div>
                                        <div class="col-lg-12">
                                        <table class="dataTable table table-striped no-footer">
                                            <thead>
                                                <tr>
                                                    <th>Action</th>
                                                    <th>#</th>
                                                    
                                                    <th>User Id</th>
                                                    <th>User Name</th>
                                                    <th>Amount </th>
                                                      <th>Service Charges</th>
                                                    <th>Net Amount</th>
                                                    <th>Posted</th>
                                                    <th>Account Number</th>
                                                    <th>Pan Number</th>
                                                    <th>IFSC</th>
                                                    <th>Branch</th>
                                                    <th>Bank</th>
                                                    <th>Date</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @php
                                                    $i=0;
                                                @endphp
                                                @foreach ($record as $item)
                                                <tr @if($item->kyc!=2) style="background-color:red;color:white"  @endif>
                                                    <th>
                                                        @if($item->posted<round($item->amount*0.90))
                                                        <a href="javascript:void(0)" class="btn btn-success" onclick="postAmount('{{$item->touser}}','{{ round($item->amount*0.90)-$item->posted }}','{{ round($item->amount)-$item->posted }}')">Post Amount</a>
                                                        @endif
                                                    </th>
                                                    <td>{{++$i}}</td>
                                                    <td>{{$item->touser}}</td>
                                                    <td>{{$item->name}}</td>
                                                    <td>{{ round($item->amount)}}</td>
                                                     <td>{{ round($item->amount*0.10)}}</td>
                                                    <td>{{ round($item->amount*0.90)}}</td>
                                                    <td>{{$item->posted}}</td>
                                                    <td>{{$item->accountnumber}}</td>
                                                    <td>{{$item->pannumber}}</td>
                                                    <td>{{$item->ifsc}}</td>
                                                    <td>{{$item->branch}}</td>
                                                    <td>{{$item->bank}}</td>
                                                    <td>{{\Carbon\Carbon::parse($closing->created_at)->format("d/m/Y")}}</td>
                                                   
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
<!-- Button trigger modal -->
<script>
    function postAmount(touser,amount,netamount)
    {
        $("#touser").val(touser);
        $("#postAmount").modal("show");
        $("#clamount").val(amount)
        $("#clamountactual").val(netamount)
    }
</script>

<!-- Modal -->
<div class="modal fade" id="postAmount" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Post Amount</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
          <div class="container">
              <form method="post" action="{{route("admin.closing.post")}}">
                  <input type="hidden" id="touser" name="touser" >
                  @csrf
        <div class="row">
            <div class="col-lg-12">
            <div class="form-group">
                <label class="cldate">Select Date</label>
                <input type="date" class="form-control" value="{{\Carbon\Carbon::parse($closing->created_at)->format("Y-m-d")}}" name="cldate" required id="cldate" placeholder="Closing Date">
            </div>
            </div>
             <div class="col-lg-12">
             <div class="form-group">
                <label class="clamount">Enter Amount</label>
                <input type="number" class="form-control" name="clamount" required id="clamount" placeholder="Enter closing amount">
                <input type="hidden" class="form-control" name="clamountactual" required id="clamountactual" placeholder="Enter closing net amount">
            </div>
            </div>
            <button class="btn btn-success">Submit</button>
        </div>
        </form>
        </div>
      </div>
     
    </div>
  </div>
</div>
<script>
function isNumber(evt) {
    evt = (evt) ? evt : window.event;
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    if (charCode > 31 && (charCode < 48 || charCode > 57) && charCode!=46) {
        return false;
    }
    return true;
}
    </script>
