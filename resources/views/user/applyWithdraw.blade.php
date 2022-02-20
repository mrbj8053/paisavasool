@extends('user.master')
@section('content')
<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-header">
                <h5>Apply Withdraw Request</h5>
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
                     <div class="col-lg-12" >
                         @include("user.message")
                         
                                    <div class="row">
                                        <div class="col-lg-12">
                                        <h4><strong>Availiable amount in Wallet is :</strong><span> ₹ {{$total}}</span></h4>
                                        </div>
                                        @if($total!=300)
                                        <div class="col-lg-12">
                                        <form method="post" action="{{route("user.withdraw.apply")}}" style="padding-left:10px;">
                                            @csrf
                                            <div class="form-group">
                                                <br>
                                                <label for="txnPassword">Enter Amount</label>
                                                <input type="number" minlength="6" required  class="form-control" maxlength="6" placeholder="Enter Amount" name="amount" id="amount" >
                                                <br>
                                                <Button type="submit" class="btn btn-success" >Submit</Button>
                                            </div>    
                                        </form>
                                        </div>
                                        @else
                                        <div class="col-lg-12">
                                        <h4 style="color:red"><strong>Minimum withdrawal amount is Rs. 300 to apply for withdraw.</h4>
                                        </div>
                                        @endif
                                        <br>
                                        <div class="col-lg-12">
                                        <h2><u>Note : </u></h2>
                                        <ul>
                                            <li><i class="fa fa-arrow-circle-right"></i>  10 % Admin Charge and 5 % TDS will be deducted from the withdrawal amount.</li>
                                        </ul>
                                        </div>
                                        
                                    </div>
                                </div>
                                <br>
                    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
