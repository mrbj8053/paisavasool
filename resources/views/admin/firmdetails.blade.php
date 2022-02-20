@extends('admin.master')
@section('content')
<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-header">
                <h5>Firm Details </h5>
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
      <div class="col">
        <div class="card">
          <!-- Card header -->
          <div class="card-header border-0">
              @if (session('status'))
            <div class="alert alert-warning">
                {{ session('status') }}
            </div>
            @endif
            <h3 class="mb-0">Update Firm Details</h3>
          </div>
          
            @include('admin.message')
          <form role="form" method="POST" action="{{ route('admin.firmdetails') }}" enctype="multipart/form-data">
                @csrf
                <div class="form-group mb-3">
                  <div class="input-group input-group-merge input-group-alternative">
                   
                    <input class="form-control @error('name') is-invalid @enderror"  name="name" value="{{ $record->name }}" required  placeholder="Name" type="text">
                    @error('name')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                  </div>
                </div>
                  <div class="form-group mb-3">
                  <div class="input-group input-group-merge input-group-alternative">
                   
                    <input class="form-control @error('telegram') is-invalid @enderror"  name="telegram" value="{{ $record->telegram }}" required  placeholder="Telegram Link" type="text">
                    @error('telegram')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                  </div>
                </div>
                  <div class="form-group mb-3">
                  <div class="input-group input-group-merge input-group-alternative">
                   
                    <input class="form-control @error('trx') is-invalid @enderror"  name="trx" value="{{ $record->trx }}" required  placeholder="trx address" type="text">
                    @error('trx')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                  </div>
                </div>
                  <div class="form-group mb-3">
                  <div class="input-group input-group-merge input-group-alternative">
                   
                    <input class="form-control @error('usd') is-invalid @enderror"  name="usd" value="{{ $record->usd }}" required  placeholder="usd address" type="text">
                    @error('usd')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                  </div>
                </div>
                 <div class="form-group mb-3">
                  <div class="input-group input-group-merge input-group-alternative">
                   
                    <input class="form-control @error('news') is-invalid @enderror"  name="news" value="{{ $record->news }}" required  placeholder="news" type="text">
                    @error('news')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                  </div>
                </div>
                 <div class="form-group mb-3">
                  <div class="input-group input-group-merge input-group-alternative">
                   
                    <input class="form-control @error('dailytip') is-invalid @enderror"  name="dailytip" value="{{ $record->dailytip }}" required  placeholder="dailytip" type="text">
                    @error('dailytip')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                  </div>
                </div>
                
                
                 
                <div class="text-center">
                  <button type="submit" class="btn btn-primary my-4">Upload Platform</button>
                </div>
              </form>
              
          <!-- Card footer -->
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
