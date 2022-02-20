@extends('user.master')
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
                    <div class="row d-none">
                        <div class="col-lg-3">
                            <label for=""><strong>Selected Plan</strong></label>
                        <select name="" id="" class="form-control" onchange="changePlan('{{ Crypt::encrypt(Auth::user()->ownid)}}',this.value)">
                                @foreach ($plans as $item)
                            <option value="{{$item->name}}"
                                @if ($item->name==$current)
                                    selected
                                @endif

                                >{{$item->name}}</option>
                                @endforeach


                            </select>
                        </div>
                    </div>
                    <div class="dt-responsive table-responsive">
                        <div class="table-responsive">
                            <table  class="table align-items-center table-flush">
                                <tr><td colspan="5"><center>
                                <img src="@if($parent->status==0){{ asset('web/vmblack.png') }} @elseif($parent->isactive==0) {{ asset('web/vmred.png') }} @else {{ asset('web/vmgreen.png') }} @endif" style="width:80px;height:80px" /><br>
                                    {{$parent->ownid}}<br>
                                    {{ userHelper::getUserDetail($parent->ownid)->name }}
                                </td>
                            </tr>
                            <tr style="text-align: center">
                                    @foreach ($childs as $child)
                                        <td style="cursor:hand">
                                        <div>
                                            <img src="@if($child->status==0){{ asset('web/vmblack.png') }} @elseif($child->isactive==0) {{ asset('web/vmred.png') }} @else {{ asset('web/vmgreen.png') }} @endif"  onmouseout=""  style="width:80px;height:80px" /><br>
                                            {{$child->ownid}}<br>
                                              {{ userHelper::getUserDetail($child->ownid)->name }}
                                            </div><br>
                                            <button class="btn btn-info" id="{{'show'.$child->ownid}}" onclick="showTitle({{'show'.$child->ownid}},{{'hide'.$child->ownid}},{{ $child->ownid }},'{{ userHelper::getUserDetail($child->ownid)->name }}','{{ userHelper::getUserDetail($child->ownid)->ownid }}','{{ \Carbon\Carbon::parse($child->created_at)->format('d/m/Y') }}','{{ $child->sponsarid }}','{{$child->amount}}')">Show Details</button>
                                            <button style="display: none" class="btn btn-warning" id="{{'hide'.$child->ownid}}" onclick="hideTitle({{'show'.$child->ownid}},{{'hide'.$child->ownid}},{{ $child->ownid }})">Hide Details</button>
                                            <br>
                                            <div id="{{ $child->ownid }}" style="margin-top: 10px"></div>
                                                <br>
                                                <a href="{{ route('user.mytree',['id'=>Crypt::encrypt($child->ownid),'name'=>$current]) }}"> <img src="{{ asset('web/down.png') }}" style="width:30px;height:40px;" />
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
    function showTitle($show,$hide,$idd,$name,$userid,$joinon,$sponsar,amount)
    {
         var tooltip = $('<div display="block"><table style="border:1px solid black;"><tr><td style="border:1px solid black;background-color:blueviolet;font-size:large;color:white;">Name :</td><td style="border:1px solid black;">'+$name+'</td></tr><tr><td style="border:1px solid black;background-color:blueviolet;font-size:large;color:white;">User Id :</td><td style="border:1px solid black;">'+$userid+'</td><tr><td style="border:1px solid black;background-color:blueviolet;font-size:large;color:white;">Join On :</td><td style="border:1px solid black;">'+$joinon+'</td></tr><tr><td style="border:1px solid black;background-color:blueviolet;font-size:large;color:white;">Sponsar :</td><td style="border:1px solid black;">'+$sponsar+'</td></tr><tr><td style="border:1px solid black;background-color:blueviolet;font-size:large;color:white;">Business :</td><td style="border:1px solid black;">'+amount+'</td></tr></table></div>');
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
