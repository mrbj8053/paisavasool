@extends('user.master')
@section('content')
<div class="row justify-content-center">

       <div class="col-lg-4 col-md-4 col-12">
        <h3 style="text-align:center;"><b style="color:blue; font-size:24px;">Money Transfer</b></h3>
    
        <div class="card" style="padding: 9px; padding-top:0px;">
            <div class="card-header">
                <h5 style="text-align: center;"><i class="fa fa-bank"></i>&nbsp; &nbsp;Punjab National Bank</h5>
                <span><!-- lorem ipsum dolor sit amet, consectetur adipisicing elit --></span>
                    <hr>
            </div>
            <div>
                <div class="card-block">
                        <form action="/action_page.php">
                        <div class="col-lg-12 col-md-12 col-12">
                           <h6>Account Holder Name: Ram</h6>
                        </div>  
                        <hr>
                        <div class="col-lg-12 col-md-12 col-12">
                           <h6>Account No.: 12552121003385</h6>
                        </div>  
                        <hr>
                         <div class="col-lg-12 col-md-12 col-12">
                           <h6>IFSC Code: PUNB0125510</h6>
                        </div>
                        <hr>
                            <div class="col-lg-12 col-md-12 col-12">
                           <h6>Branch: Sardulgarh</h6>
                        </div>  
                        <hr>     
                         <div class="col-lg-12 col-md-12 col-12">
                           <h6>Registered Phone No.: 9876548131</h6>
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