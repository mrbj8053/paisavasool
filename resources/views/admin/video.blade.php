@extends('admin.master')
@section('content')

<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-header pb-0" >
                <h5>Video </h5>
                <hr>
               <div class="card-header-right">
                    <ul class="list-unstyled card-option">
                        <li><i class="feather icon-maximize full-card"></i></li>
                        <li><i class="feather icon-minus minimize-card"></i></li>
                        <li><i class="feather icon-trash-2 close-card"></i></li>
                    </ul>
                </div>
            </div>

                <div class="card-block">
                    <div class="dt-responsive table-responsive">
                        <div id="basic-col-reorder_wrapper" class="dataTables_wrapper dt-bootstrap4">

                            <div class="row">
      <div class="col">
        <div class="card">
          <!-- Card header -->
          <div class="card-header border-0 pt-0">
              @if (session('status'))
            <div class="alert alert-warning">
                {{ session('status') }}
            </div>
            @endif
            <h3 class="mb-0"> Add Video</h3>
          </div>

            @include('admin.message')
          <form role="form" method="POST" action="{{ route('admin.video.add') }}" enctype="multipart/form-data">
                @csrf
                <div class="row">

                    <div class="col-md-6">
                  <div class="form-group ">
                     <label for="title">Title<span style="color:red">*</span></label>
                    <input class="form-control @error('title') is-invalid @enderror" name="title" value="" required  placeholder="title" type="text">
                    @error('title')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror

                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                     <label for="video">Video</label>
                    <input class="form-control @error('video') is-invalid @enderror" name="video" value=""   placeholder="url" type="url">
                    @error('video')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror

                  </div>
                </div>
             </div>


                <div class="col-md-6">
                  <button type="submit" class="btn btn-primary my-4">

                    Add Video

                </button>
                </div>
              </form>

          <!-- Card footer -->
        </div>
      </div>
    </div>
    <div class="card-block">

            <div id="basic-col-reorder_wrapper" class="dataTables_wrapper dt-bootstrap4">
                <h3 class="mb-0 text-center"> All Video</h3>
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
                                <tr role="row">
                                    <th>#</th>
                                    <th>Sr no.</th>
                                    <th>Title</th>
                                    <th>Video</th>


                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $i=0;
                                @endphp
                                @foreach($video as $item)
                                <tr role="row" class="odd">

                                <td>

                                    <a onclick="deleteConfirm('{{ route('admin.video.delete', ['id'=>Crypt::encrypt($item->id)]) }}')" style="color:white;padding: 6px;" class="btn btn-danger "><i class="feather icon-trash-2 " style="margin-right: 0px;"></i></a>


                                </td>
                                <td>{{++$i}}</td>
                                <td>{{$item->title}}</td>
                                <td>{{ $item->video }}</td>

                               @endforeach
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
</div>

<script>
    function deleteConfirm(link)
    {
       var cs=confirm("Do you want to delete this Video ?");
       if(cs==true)
       {
        document.location.href=link;
       }
    }
    </script>
@endsection
