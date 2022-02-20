@extends('user.master')
@section('content')
<div class="row justify-content-center">

       <div class="col-lg-8 col-md-8 col-12">
        <h3><b style="color:blue; font-size:24px;">Transfer E-PIN</b></h3>
    
        <div class="card" style="padding: 9px; padding-top:0px;">
            <div class="card-header">
                <h5 style="text-align: center;"><i class="fa fa-share"></i>&nbsp; &nbsp;Transfer E-PIN</h5>
                <span><!-- lorem ipsum dolor sit amet, consectetur adipisicing elit --></span>
                    <hr>
            </div>
            <div>
                <div class="card-block">
                        <form action="/action_page.php">
                        <div class="col-lg-12 col-md-12 col-12">
                          <div class="form-group">
                            <label for="userepid">User Id:<span style="color:red;">*</span></label>
                            <input type="email" class="form-control" id="userepid" placeholder="Enter User Id" name="userid">
                          </div>
                        </div>
                        <hr>
                     
                      <div class="col-lg-12 col-md-12 col-12">
                          <div class="form-group">
                            <label for="nop">NOP (NUMBER OF E-PINS)<span style="color:red;">*</span></label>
                            <input type="number" class="form-control" id="nop" placeholder="Enter Password" name="pwd">
                          </div>
                      </div>
                      <hr>
                      <div class="col-lg-12 col-md-12 col-12">
                          <div class="form-group">
                            <label for="txnpass">TXN PASSWORD <span style="color:red;">*</span></label>
                            <input type="text" class="form-control" id="txnpass" placeholder="Enter txn password" name="pwd">
                          </div>
                      </div>
                    
                        <hr>
                         <div class="col-lg-12 col-md-12 col-12">
                          <button type="submit" class="btn btn-default" style="background:blue; color:#fff;">Submit</button>
                         </div>
                        </form>
                      </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection