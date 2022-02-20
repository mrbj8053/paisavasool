@extends('admin.master')
@section('content')
<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-header">
                <h5>Gallery </h5>
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
            <h3 class="mb-0">Upload Image In Gallery</h3>
          </div>

            @include('admin.message')
          <form role="form" method="POST" action="{{ route('admin.gallery.upload') }}" enctype="multipart/form-data">
                @csrf
                <div class="form-group mb-3">
                  <div class="input-group input-group-merge input-group-alternative">

                    <input class="form-control @error('Image') is-invalid @enderror" name="Image" value="{{ old('Image') }}" required  placeholder="Select image" type="file">
                    @error('Image')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
                  </div>
                </div>


                <div class="text-center">
                  <button type="submit" class="btn btn-primary my-4">Upload Image</button>
                </div>
              </form>

          <!-- Card footer -->
        </div>
      </div>
    </div>
<div class="row">
      <div class="col">
        <div class="card container">
          <!-- Card header -->
          <div class="card-header border-0">
            <h3 class="mb-0">Gallery</h3>
          </div>
          <!-- Light table -->

          <div class="row" style="padding:10px">
              @foreach($gallery as $u)
              <div class='col-md-4' style="margin-top:10px">
                   <img src="{{ asset('Gallery/'.$u->image) }}" style="width:300px;height:300px;" />
                   <br><br>
                    <a href="{{ route('admin.gallery.delete',['id'=>Crypt::encrypt($u->id)]) }}"  class="btn btn-danger">Delete</a>
              </div>
              @endforeach
              <div class='col-md-4'>

              </div>
          </div>

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
