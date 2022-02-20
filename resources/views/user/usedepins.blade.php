@extends('user.master')
@section('content')
<style>
button.dt-button, div.dt-button, a.dt-button, button.dt-button:focus:not(.disabled), div.dt-button:focus:not(.disabled), a.dt-button:focus:not(.disabled), button.dt-button:active:not(.disabled), button.dt-button.active:not(.disabled), div.dt-button:active:not(.disabled), div.dt-button.active:not(.disabled), a.dt-button:active:not(.disabled), a.dt-button.active:not(.disabled) {
    background-color: blue;
    /* border-color: #01a9ac; */
    border-radius: 2px;
    color: #fff;
    background-image: none;
    font-size: 17px;
    padding: 4px;
}
.dataTables_wrapper .dataTables_filter {
    float: right;
    text-align: right;
    margin-top: -26px;
}

.btn {
  box-sizing: border-box;
  -webkit-appearance: none;
     -moz-appearance: none;
          appearance: none;
  background-color: transparent;
  border: 2px solid #e74c3c;
  border-radius: 0.6em;
  color: #e74c3c;
  cursor: pointer;
  display: -webkit-box;
  display: -webkit-flex;
  display: -ms-flexbox;
  display: flex;
  -webkit-align-self: center;
      -ms-flex-item-align: center;
          align-self: center;
  font-size: 12px;
  font-weight: 400;
  line-height: 1;
  padding: 12px 12px;
  text-decoration: none;
  text-align: center;
  text-transform: uppercase;
  font-family: 'Montserrat', sans-serif;
  font-weight: 700;
}
.btn:hover, .btn:focus {
  color: #fff;
  outline: 0;
  background-color: blue;
}

</style>
<div class="row">
    <div class="col-sm-12">
        <h5>Used E-Pins</h5><br>
        <h3><b style="color:blue; font-size:21px;">Dashboard</b><i class="fa fa-arrow-right"></i><span style="font-size:18px;">&nbsp;Epins / Used E-Pins</span></h3>
       <div class="card">
            <div class="card-header">
                <h5><i class="fa fa-table"></i>&nbsp; &nbsp; Used E-Pins</h5>
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
                                <div class="col-xs-12 col-sm-12" >
                                    <table id="basic-col-reorder" class="table table-striped table-bordered nowrap dataTable" role="grid" aria-describedby="basic-col-reorder_info">
                                        <thead>
                                            <tr role="row" style="text-align:center;">
                                                <th>#</th>
                                                <th>USER ID</th>
                                                <th>EPIN</th>
                                                <th>STATUS</th>
                                                <th>USED FOR</th>
                                                <th>AMOUNT</th>
                                                <th>DATE</th>
                                             
                                            </tr>
                                        </thead>
                                        <tbody>
                                       
                                            <tr role="row" class="odd textcenter">

                                            <td>1</td>
                                           <td>XXXX</td>
                                            <td>Ram</td>
                                            <td><button class="btn third">USED</button></td>
                                            <td>XXXXXXXXX</td>
                                            <td style="padding-right:1.5rem; padding-left:1.5rem;">Amount</td>
                                            <td>Date</td>
                                           
                                         
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
