@extends('admin.master')
@section('content')

<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-header pb-0" >
                <h5>Slider </h5>
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
                    <div class="dt-responsive">
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
            <h3 class="mb-0">Add Slider</h3>
          </div>

            @include('admin.message')
          <form role="form" method="POST" action="{{ route('admin.slider.add') }}" enctype="multipart/form-data">
                @csrf
                <div class="row">

                    <div class="col-md-6">
                  <div class="form-group ">
                     <label for="image">Image<span style="color:red">*</span></label>
                    <input class="form-control @error('image') is-invalid @enderror" name="image" value="" required  placeholder="image" type="file">
                    @error('image')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror

                  </div>
                </div>
                <div class="col-md-12">
                  <div class="form-group">
                     <label for="description">Description</label>
                    <textarea class="summernote form-control @error('description') is-invalid @enderror" name="description" value=""   placeholder="description" type="text"></textarea>
                    @error('description')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror

                  </div>
                </div>




             </div>


                <div class="col-md-6">
                  <button type="submit" class="btn btn-primary my-4">

                    Add Slider

                </button>
                </div>
              </form>

          <!-- Card footer -->
        </div>
      </div>
    </div>

    @if(empty($meeting_id))
    <div class="card-block">

        <div class="table-responsive dt-responsive">
            <div id="dom-jqry_wrapper" class="dataTables_wrapper dt-bootstrap4">

                <div class="row">
                    <div class="col-xs-12 col-sm-12">
                        <table  class="table table-striped table-bordered nowrap dataTable" role="grid" aria-describedby="dom-jqry_info">
                            <thead>
                                <tr role="row">
                                    <th class="sorting_asc" tabindex="0" aria-controls="dom-jqry" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Name: activate to sort column descending">Sr.</th>
                                    <th class="sorting" tabindex="0" aria-controls="dom-jqry" rowspan="1" colspan="1" aria-label="Position: activate to sort column ascending">Action</th>
                                    <th class="sorting" tabindex="0" aria-controls="dom-jqry" rowspan="1" colspan="1" aria-label="Office: activate to sort column ascending" >Image</th>
                                    <th class="sorting" tabindex="0" aria-controls="dom-jqry" rowspan="1" colspan="1" aria-label="Office: activate to sort column ascending">Description</th>
                                 </tr>
                            </thead>
                            <tbody>
                                @php
                                    $i=0;
                                @endphp
                                @foreach ($all_slider as $item)

                                <tr role="row" class="odd">
                                    <td class="sorting_1">{{ ++$i }}</td>
                                    <td><a onclick="deleteConfirm('{{ route('admin.slider.delete', ['id'=>Crypt::encrypt($item->id)]) }}')" style="color:white;padding: 6px;" class="btn btn-danger "><i class="feather icon-trash-2 " style="margin-right: 0px;"></i></a>
                                    </td>
                                    <td><img src="{{ asset('Slider/'.$item->image) }}" style="width:100px;height:100px;" /></td>
                                    <td>{{ $item->description }}</td>
                                </tr>
                                @endforeach
                            </tbody>

                        </table>
                    </div>
                </div>
            </div>
        </div>

      </div>
    @endif




                        </div>
                    </div>
                </div>
            </div>
        </div>
</div>

<script>
    function deleteConfirm(link)
    {
       var cs=confirm("Do you want to delete this Slider ?");
       if(cs==true)
       {
        document.location.href=link;
       }
    }
    </script>
@endsection
