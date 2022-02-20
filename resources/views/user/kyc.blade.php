@extends('user.master')
@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h5>Update Profile</h5>
                    <hr>
                    <span>
                        <!-- lorem ipsum dolor sit amet, consectetur adipisicing elit --></span>
                    <div class="card-header-right">
                        <ul class="list-unstyled card-option">
                            <li><i class="feather icon-maximize full-card"></i></li>

                        </ul>
                    </div>
                </div>
                <div>

                    <div class="card-block">
                        @include('user.message')
                        <div class="card-body">
                            @if (Auth::user()->kyc == 0)
                                <div class="alert alert-success background-danger">
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <i class="icofont icofont-close-line-circled text-white"></i>
                                    </button>
                                    <strong> Kyc Details not updated</strong>
                                </div>
                            @elseif(Auth::user()->kyc==1)
                                <div class="alert alert-success background-warning">
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <i class="icofont icofont-close-line-circled text-white"></i>
                                    </button>
                                    <strong> Details uploaded verification pending</strong>
                                </div>
                            @else
                                <div class="alert alert-success background-success">
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <i class="icofont icofont-close-line-circled text-white"></i>
                                    </button>
                                    <strong> KYC Verified Successfully</strong>
                                </div>
                            @endif
                            <form method="POST" action="{{ route('user.kyc.update') }}" enctype="multipart/form-data">
                                @csrf
                                <!-- Address -->
                                <div class="pl-lg-4">
                                    <div class="row">
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label class="form-control-label" for="input-city">PAN Number</label>
                                                <input value="{{ Auth::user()->pannumber }}" type="text"
                                                    class="form-control  @error('PanNumber') is-invalid @enderror"
                                                     name="PanNumber" min="10" max="10" placeholder="PAN Number">
                                                @error('PanNumber')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label class="form-control-label" for="input-country">Account Number</label>
                                                <input value="{{ Auth::user()->accountnumber }}" type="number"
                                                    class="form-control  @error('AccountNumber') is-invalid @enderror"
                                                    required="" name="AccountNumber" minlength="10" maxlength="16"
                                                    placeholder="Account Number">
                                                @error('AccountNumber')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label class="form-control-label" for="input-country">Bank</label>
                                                <input type="text" value="{{ Auth::user()->bank }}"
                                                    class="form-control  @error('Bank') is-invalid @enderror" required=""
                                                    placeholder="Bank Name" name="Bank">
                                                @error('Bank')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                        </div>
                                    
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label class="form-control-label" for="input-city">IFSC</label>
                                                <input type="text" value="{{ Auth::user()->ifsc }}"
                                                    class="form-control  @error('IFSC') is-invalid @enderror" required=""
                                                    placeholder="IFSC Code" name="IFSC">
                                                @error('IFSC')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label class="form-control-label" for="input-country">Branch</label>
                                                <input type="text" value="{{ Auth::user()->branch }}"
                                                    class="form-control  @error('Branch') is-invalid @enderror" required=""
                                                    placeholder="Branch" name="Branch">
                                                @error('Branch')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label class="form-control-label" for="input-country">Mobile</label>
                                                <input type="num" value="{{ Auth::user()->kycmobile }}" minlength="10"
                                                    maxlength="10"
                                                    class="form-control  @error('KYCMOBILE') is-invalid @enderror"
                                                    required="" placeholder="Mobile" name="KYCMOBILE">
                                                @error('KYCMOBILE')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-lg-4 ">
                                            <div class="form-group">
                                                <label class="form-control-label" for="input-country">Nominee Name</label>
                                                <input type="text" value="{{ Auth::user()->kycname }}"
                                                    class="form-control @error('KYCNAME') is-invalid @enderror" 
                                                    placeholder="Nominee Name" name="KYCNAME">
                                                @error('KYCNAME')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-lg-4 ">
                                            <div class="form-group">
                                                <label class="form-control-label" for="input-country">Nominee
                                                    Relation</label>
                                                <input type="text" value="{{ Auth::user()->kycrelation }}"
                                                    class="form-control @error('KYCRELATION') is-invalid @enderror"
                                                     placeholder="Nominee Relation" name="KYCRELATION">
                                                @error('KYCRELATION')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-lg-4 ">
                                            <div class="form-group">
                                                <label class="form-control-label" for="input-country">Age</label>
                                                <input  type="text" value="{{ Auth::user()->kycage }}"
                                                    class="form-control @error('KYCAGE') is-invalid @enderror" 
                                                    placeholder="Age" name="KYCAGE">
                                                @error('KYCAGE')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-lg-4 ">
                                            <div class="form-group">
                                                <label class="form-control-label" for="input-country">Pan Image</label>
                                                <input type="file" name="PanImage"
                                                    class="form-control @error('PanImage') is-invalid @enderror" value="">
                                                @error('PanImage')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-lg-4 ">
                                            <div class="form-group">
                                                <label class="form-control-label" for="input-country">Adhaar Front</label>
                                                <input type="file" name="AdharFront"
                                                    class="form-control @error('AdharFront') is-invalid @enderror">
                                                @error('AdharFront')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror

                                            </div>
                                        </div>
                                        <div class="col-lg-4 ">
                                            <div class="form-group">
                                                <label class="form-control-label" for="input-country">Adhaar Back</label>
                                                <input type="file" name="AdharBack"
                                                    class="form-control @error('AdharBack') is-invalid @enderror">
                                                @error('AdharBack')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-lg-4 ">
                                            <div class="form-group">
                                                <label class="form-control-label" for="input-country">Passbook/Cancel
                                                    Check</label>
                                                <input type="file"  name="Passbook"
                                                    class="form-control @error('Passbook') is-invalid @enderror">
                                                @error('Passbook')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                        </div>
                                        @if(Auth::user()->kyc!=2)
                                        <div class="col-lg-4 ">
                                            <div class="form-group">
                                                <br>
                                                <button type="submit" class="form-control btn btn-primary">Save</button>
                                            </div>
                                        </div>
                                        @endif
                                        <div class="col-lg-4">

                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label class="form-control-label" for="input-country">Pan Image</label>
                                                <img src="{{ asset('kyc').'/'.Auth::user()->panimage }}" style="width:100%;height:200px">

                                            </div>
                                        </div>
                                        <div class="col-lg-4 ">
                                            <div class="form-group">
                                                <label class="form-control-label" for="input-country">Adhaar Front</label>
                                                <img src="{{ asset('kyc').'/'.Auth::user()->adharimage }}" style="width:100%;height:200px">
                                            </div>
                                        </div>
                                        <div class="col-lg-4 ">
                                            <div class="form-group">
                                                <label class="form-control-label" for="input-country">Adhaar Back</label>
                                                <img src="{{ asset('kyc').'/'.Auth::user()->adharbackimage }}" style="width:100%;height:200px">
                                            </div>
                                        </div>
                                        <div class="col-lg-4 ">
                                            <div class="form-group">
                                                <label class="form-control-label" for="input-country">Passbook/Cancel
                                                    Check</label>
                                                <img src="{{ asset('kyc').'/'.Auth::user()->passbookimage }}" style="width:100%;height:200px">
                                            </div>
                                        </div>

                                    </div>
                                </div>

                        </div>
                        </form>
                    </div>


                </div>
            </div>
        </div>
    </div>
    </div>
@endsection
