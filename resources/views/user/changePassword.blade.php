@extends('user.master')
@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h5>Change Password</h5>
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
                        <div class="card-body text-center">
                            <form role="form" method="POST" action="{{ route('user.password.change') }}">
                                @csrf
                                <div class="form-group mb-3 col-lg-4">
                                  <div class="input-group input-group-merge input-group-alternative">
                                    <div class="input-group-prepend">
                                      <span class="input-group-text"><i class="bi bi-key"></i></span>
                                    </div>
                                      <div class="toggle-input-container">
                                    <input class="passwordToggle form-control @error('OldPassword') is-invalid @enderror" name="OldPassword" value="{{ old('Password') }}" required autofocus placeholder="Old Password" type="password">
                                     <i class="fa fa-eye toggle-icon toggler"></i>
                                    @error('OldPassword')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                                </div>
                                  </div>
                                </div>
                                <div class="form-group col-lg-4">
                                  <div class="input-group input-group-merge input-group-alternative">
                                    <div class="input-group-prepend">
                                      <span class="input-group-text"><i class="bi bi-key"></i></span>
                                    </div>
                                      <div class="toggle-input-container">
                                    <input class="passwordToggle form-control @error('NewPassword') is-invalid @enderror" name="NewPassword" required autocomplete="current-password"  minlength="6" placeholder="New Password" type="password">
                                    <i class="fa fa-eye toggle-icon toggler"></i>
                                    @error('NewPassword')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                                </div>
                                  </div>
                                </div>
                                  <div class="form-group col-lg-4">
                                  <div class="input-group input-group-merge input-group-alternative">
                                    <div class="input-group-prepend">
                                      <span class="input-group-text"><i class="bi bi-key"></i></span>
                                    </div>
                                      <div class="toggle-input-container">
                                    <input class="passwordToggle form-control @error('ConfirmPassword') is-invalid @enderror" name="ConfirmPassword" required  minlength="6" autocomplete="current-password" placeholder="Confirm Password" type="password">
                                    <i class="fa fa-eye toggle-icon toggler"></i>
                                    @error('ConfirmPassword')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                                </div>
                                  </div>
                                </div>
                                <div class="text-left m-15">
                                  <button type="submit" class="btn btn-primary my-4">Change Password</button>
                                </div>
                              </form>
                    </div>


                </div>
            </div>
        </div>
    </div>
    </div>
@endsection
