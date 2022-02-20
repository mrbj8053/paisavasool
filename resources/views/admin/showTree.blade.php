@extends('admin.master')
@section('content')
<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-header">
                <h5>My Tree</h5>
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
                    <div class="row" >
                        <dir class="col-md-4">
                          <form method="POST" action="{{ route('admin.showtree')}}">
                            <label for="">Selected User</label>
                              @csrf
                              <select name="id" class="form-control selectbox"  required  >

                                  @foreach ($all as $item)
                              <option value="{{ Crypt::encrypt($item->ownid) }}" @if ($parent->ownid==$item->ownid) selected @endif >{{ $item->name."(".$item->ownid.")"  }}</option>
                                  @endforeach
                              </select>
                             
                                {{-- <label for=""><strong>Selected Plan</strong></label>
                            <select name="plan" id="" class="form-control">
                                    @foreach ($plans as $item)
                                <option value="{{$item->name}}"
                                    @if ($item->name==$current)
                                        selected
                                    @endif
                                    
                                    >{{$item->name}}</option>
                                    @endforeach
                                </select>--}}
                            </div>
                              <button type="submit"  class="btn btn-warning" style="margin:10px;">Submit</button>
                              </form>
                        </dir>
                    </div>
                    <div class="dt-responsive table-responsive">
                        <div class="table-responsive">
                            <table  class="table align-items-center table-flush">
                                <tr><td colspan="5"><center>
                                <img src="{{ asset('web/user.png') }}" style="height:100px" /><br>
                                    {{$parent->ownid}}<br>
                                    {{ userHelper::getUserDetail($parent->ownid)->name }}
                                </td>
                            </tr>
                            <tr style="text-align: center">
                                    @foreach ($childs as $child)
                                        <td style="cursor:hand">
                                        <div>
                                            <img src="{{ asset('web/user.png') }}"  onmouseout=""  style="height:100px" /><br>
                                            {{$child->ownid}}<br>
                                              {{ userHelper::getUserDetail($child->ownid)->name }}
                                            </div><br>
                                            <button class="btn btn-info" id="{{'show'.$child->ownid}}" onclick="showTitle({{'show'.$child->ownid}},{{'hide'.$child->ownid}},{{ $child->ownid }},'{{ userHelper::getUserDetail($child->ownid)->name }}','{{ userHelper::getUserDetail($child->ownid)->ownid }}','{{ \Carbon\Carbon::parse($child->created_at)->format('d/m/Y') }}','{{ $child->sponsarid }}')">Show Details</button>
                                            <button style="display: none" class="btn btn-warning" id="{{'hide'.$child->ownid}}" onclick="hideTitle({{'show'.$child->ownid}},{{'hide'.$child->ownid}},{{ $child->ownid }})">Hide Details</button>
                                            <br>
                                            <div id="{{ $child->ownid }}" style="margin-top: 10px"></div>
                                                <br>
                                                <a href="javascript:void(0)" onclick="document.getElementById('form{{ $child->ownid }}').submit();"> <img src="{{ asset('web/down.png') }}" style="width:30px;height:40px;" />
                                                    <form id="form{{ $child->ownid }}" action="{{ route('admin.showtree') }}" method="POST" style="display: none;">
                                                        @csrf
                                                        <input type="hidden" name="id" value="{{Crypt::encrypt($child->ownid)  }}">
                                                        <input type="hidden" name="plan" value="{{$current }}">
                                                    </form>
                                            </a>
                                         </td>
                                    @endforeach


                            </tr>

                            </table>
                          </div>
                    </div> 
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    function showTitle($show,$hide,$idd,$name,$userid,$joinon,$sponsar)
    {
         var tooltip = $('<div display="block"><table style="border:1px solid black;"><tr><td style="border:1px solid black;background-color:blueviolet;font-size:large;color:white;">Name :</td><td style="border:1px solid black;">'+$name+'</td></tr><tr><td style="border:1px solid black;background-color:blueviolet;font-size:large;color:white;">User Id :</td><td style="border:1px solid black;">'+$userid+'</td><tr><td style="border:1px solid black;background-color:blueviolet;font-size:large;color:white;">Join On :</td><td style="border:1px solid black;">'+$joinon+'</td></tr><tr><td style="border:1px solid black;background-color:blueviolet;font-size:large;color:white;">Sponsar :</td><td style="border:1px solid black;">'+$sponsar+'</td></tr></table></div>');
        tooltip.appendTo($($idd));
        $($show).hide();
        $($hide).show();
    
                        }
    
    function hideTitle($show,$hide,$idd)
        {
        $($idd).empty();
        $($show).show();
        $($hide).hide();
        }

        function changePlan($id,$plan)
        {
            document.location.href='{{ url('/') }}'+'/mytree/'+$id+'/'+$plan;
        }
      </script>
@endsection
