@extends('user.master')
@section('content')
<div class="row justify-content-center">

       <div class="col-lg-8 col-md-8 col-12">
        <h3 style="text-align:center;"><b style="color:blue; font-size:24px;">Change Password</b></h3>
    
        <div class="card" >
            <div class="card-header" style="font-size:19px;">
                <h5><i class="fa fa-edit"></i>&nbsp; &nbsp;Change Password</h5>
                <span><!-- lorem ipsum dolor sit amet, consectetur adipisicing elit --></span>
                    <hr>
            </div>
            <div>
                <div class="card-block">
                        <form action="/action_page.php">
                        <div class="col-lg-12 col-md-12 col-12">
                          <div class="form-group">
                            <label for="userid">Current Password<span style="color:red;">*</span></label>
                            <input type="password" class="form-control" id="" placeholder="Current Password" name="password">
                          </div>
                        </div>
                        <hr>
                        <div class="col-lg-12 col-md-12 col-12">
                          <div class="form-group">
                            <label for="">New Password<span style="color:red;">*</span></label>
                            <input type="password" class="form-control" id="" placeholder="New Password" name="newpassword">
                          </div>
                        </div>
                        <hr>  
                         <div class="col-lg-12 col-md-12 col-12">
                          <div class="form-group">
                            <label for="">Verify New Password<span style="color:red;">*</span></label>
                            <input type="password" class="form-control" id="" placeholder="Verify new Password" name="confirmpassword">
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