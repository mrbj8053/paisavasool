@extends('admin.master')
@section('content')
@if(!empty($meeting_id))
@php
 $meeting=userHelper::get_zoom_meeting($meeting_id);
@endphp
@endif
<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-header pb-0" >
                <h5>Meeting </h5>
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
            <h3 class="mb-0"> @if(!empty($meeting)) Edit @else Add @endif Zoom Meeting </h3>
          </div>

            @include('admin.message')
          <form role="form" method="POST" action="{{ route('admin.zoom.meeting.add') }}" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <input type="hidden" @if(!empty($meeting_id)) value="{{$meeting_id}}" @else value="" @endif  name="id" id="id"/>

                    <div class="col-md-6">
                  <div class="form-group ">
                     <label for="title">Title<span style="color:red">*</span></label>
                    <input class="form-control @error('title') is-invalid @enderror" name="title" value="{{!empty($meeting)?$meeting->title:'' }}" required  placeholder="title" type="text">
                    @error('title')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror

                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                     <label for="description">Description</label>
                    <input class="form-control @error('description') is-invalid @enderror" name="description" value="{{!empty($meeting)?$meeting->description:'' }}"   placeholder="description" type="text">
                    @error('description')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror

                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                     <label for="topic">Topic</label>
                    <input class="form-control @error('topic') is-invalid @enderror" name="topic" value="{{!empty($meeting)?$meeting->topic:'' }}"   placeholder="topic" type="text">
                    @error('topic')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror

                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                     <label for="time">Timing</label>
                    <input class="form-control @error('time') is-invalid @enderror" name="time" value="{{!empty($meeting)?$meeting->time:old('time')}}"    type="text">
                    @error('time')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror

                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                     <label for="meeting_id">Meeting ID<span style="color: red">*</span></label>
                    <input class="form-control @error('meeting_id') is-invalid @enderror" required name="meeting_id" value="{{!empty($meeting)?$meeting->meeting_id:'' }}"    type="text">
                    @error('meeting_id')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror

                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                     <label for="passcode">Passcode</label>
                    <input class="form-control @error('passcode') is-invalid @enderror" name="passcode" value="{{!empty($meeting)?$meeting->passcode:'' }}"    type="text">
                    @error('passcode')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror

                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                     <label for="link">Link</label>
                    <input class="form-control @error('link') is-invalid @enderror" name="link" value="{{!empty($meeting)?$meeting->link:'' }}"    type="url">
                    @error('link')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror

                  </div>
                </div>
             </div>


                <div class="col-md-6">
                  <button type="submit" class="btn btn-primary my-4">
                      @if(!empty($meeting_id))
                    Edit Meeting
                    @else
                    Add Meeting
                    @endif
                </button>
                </div>
              </form>

          <!-- Card footer -->
        </div>
      </div>
    </div>
    @if(empty($meeting_id))
    <div class="card-block">

            <div id="basic-col-reorder_wrapper" class="dataTables_wrapper dt-bootstrap4" >
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
                        <table id="basic-col-reorder" class="dt-responsive table-responsive table table-striped table-bordered nowrap dataTable" role="grid" aria-describedby="basic-col-reorder_info">
                            <thead>
                                <tr role="row">
                                    <th>#</th>
                                    <th>Sr no.</th>
                                    <th>Title</th>
                                    <th>Description</th>
                                    <th>Topic</th>
                                    <th>Time</th>
                                    <th>Meeting ID</th>
                                    <th>Link</th>
                                    <th>Passcode</th>

                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $i=0;
                                @endphp
                                @foreach($zoom_meeting as $zoom)
                                <tr role="row" class="odd">

                                <td>

                                    <a href="{{ route('admin.zoom_meeting.show', ['id'=>$zoom->id]) }}" style="color:white;padding: 6px;" class="btn btn-warning "><i class="fa fa-pencil-square-o"></i></a>
                                    <a onclick="deleteConfirm('{{ route('admin.zoom_meeting.delete', ['id'=>Crypt::encrypt($zoom->id)]) }}')" style="color:white;padding: 6px;" class="btn btn-danger "><i class="feather icon-trash-2 " style="margin-right: 0px;"></i></a>


                                </td>
                                <td>{{++$i}}</td>
                                <td>{{$zoom->title}}</td>
                                <td>{{$zoom->description}}</td>
                                <td>{{$zoom->topic}}</td>
                                <td>{{$zoom->time}}</td>
                                <td>{{$zoom->meeting_id}}</td>
                                <td>{{$zoom->link}}</td>
                                <td>{{$zoom->passcode}}</td>


                               @endforeach
                                </tr>
                            </tbody>

                        </table>
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
       var cs=confirm("Do you want to delete this Meeting ?");
       if(cs==true)
       {
        document.location.href=link;
       }
    }
    </script>
@endsection
