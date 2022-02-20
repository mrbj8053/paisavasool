@extends('user.master')
@section('content')
<div class="d-flex">
                <div class="col-12 col-sm-12 col-lg-12 col-md-12 d-none">
                    <div class="card card-style">
                        <div class="content" style="height: auto;">
                            <div class="py-1">
                                <div class="text-center align-self-center">
                                    <img alt=".." src="{{asset('web')}}/images//pictures/qrcode.png" style="width: 35%;" />
                                </div>
                                <div class="text-center align-self-center ps-1">
                                    <h5 class="pt-1 mb-n1">Invite your contacts</h5>
                                    <p>or Friends and Earn Rewards</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <div class="card card-style" style="background-image: url('{{asset('web')}}/images//pictures/shareimg.jpg');">
                <div class="content">
                    <div class=" py-1">

                        <div class=" align-self-center ps-1">

                            <h4 class="pt-1 mb-n1 text-center" style="color: #fff;">Refer and Earn Rewards</h4>
                            <p class="text-center" style="color: #fff;">Share your referal link and start earning</p>
                            <div class="d-flex" style="background: #fff;
                            border-radius: 10px;
                            padding: 2px 11px;">

                                <input type="text" value="{{route('register')}}/{{Auth::user()->ownid}}" id="myInput" style="width: 69%;
                                border: unset;">
                                <button onclick="copyToClipBoard('{{route('register')}}/{{Auth::user()->ownid}}')" class="btn btn-success">Copy text</button>
                                <!-- <h4>link here cb fddfg fgdfgd dfgdfg dfgdfg hyrt fdgdfg </h4>
                                <button class="btn btn-success" style="padding: 10px 19px;">Copy Link</button> -->
                            </div>
                        </div>
                        <div style="display:flex;margin-top:10px;justify-content: end;" class="justify-content-sm-center">
               <a href="https://api.whatsapp.com/send?text=Join with my Link : {{route('register')}}/{{Auth::user()->ownid}}" target="_blank"> <p style="background: green;
    width: 50px;
    height: 50px;
    color: white;
    padding: 12px;
    font-size: 29px;
    border-radius: 50%;
    padding-top:10px;">
                   <i class="bi bi-whatsapp"></i>
                </p></a>
                <a href="https://www.facebook.com/sharer/sharer.php?u=Join with my Link : {{route('register')}}/{{Auth::user()->ownid}}&amp;title={{config('app.name')}}" target="_blank">  <p style="background: #2a66d2;
    width: 50px;
    height: 50px;
    color: white;
    padding: 14px;
    font-size: 29px;
    border-radius: 50%;
    padding-top: 10px;
    padding-left: 11px;
    margin-left:10px">
                 <i class="bi bi-telegram"></i>
                    
                </p></a>
               <a href="javascript:void(0);" onclick="copyToClipBoard('{{route('register')}}/{{Auth::user()->ownid}}')">   <p style="   background: #f09433; 
background: -moz-linear-gradient(45deg, #f09433 0%, #e6683c 25%, #dc2743 50%, #cc2366 75%, #bc1888 100%); 
background: -webkit-linear-gradient(45deg, #f09433 0%,#e6683c 25%,#dc2743 50%,#cc2366 75%,#bc1888 100%); 
background: linear-gradient(45deg, #f09433 0%,#e6683c 25%,#dc2743 50%,#cc2366 75%,#bc1888 100%); 
filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#f09433', endColorstr='#bc1888',GradientType=1 );
    width: 50px;
    height: 50px;
    color: white;
    padding: 14px;
    font-size: 25px;
    border-radius: 50%;
    padding-top: 10px;
    padding-left: 12px;
    margin-left: 13px;">
                    <i class="bi bi-clipboard"></i>
                </p></a>
                </div>

                    </div>



                </div>
            </div>
            @endsection