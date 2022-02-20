@extends('user.master')
@section('content')
<div class="card card-style">
                <div class="d-flex" style="overflow-x: auto;width: 100%;">
                @foreach($levelCount as $counting)
                    <div class="col-4 col-sm-4 col-lg-4 col-md-4">
                        <div class="content" style="height: auto;">
                            <div class="py-1">
                                <div class="text-center align-self-center">
                                    <button class="btn btn-success" style="padding: 7px 31px;">Lev {{$counting->level}}</button>
                                </div>
                                <div class="text-center align-self-center ps-1">
                                    <h5 class="pt-1 mb-n1">{{$counting->count}}</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                    
                </div>

            </div>
            <div class="card card-style">
                <div class="d-flex" style="
    padding: 10px;
">
                    <table style="width: 100%;margin-left: 15px;
                    margin-right: 15px;;">
                        <thead style="border-top: 1px solid #ccc;
                        border-bottom: 1px solid #ccc;">
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Date</th>
                                <th scope="col">Mobile</th>
                                <th scope="col">Level</th>
                                <th scope="col">Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php 
                            $i=0;
                            @endphp
                            @foreach($record as $rc)
                            <tr @if($rc->isactive==0) style="background:red;color:white" @else  style="background:green;color:white"  @endif>
                                <th scope="row">{{++$i}}</th>
                                <td>{{\Carbon\Carbon::parse($rc->created_at)->format("d-m-Y")}}</td>
                                <td>XXXXX-XX@php echo substr($rc->mobile,-3,3) @endphp</td>
                                <th>{{$rc->level}}</th>
                                <td>{{$rc->plan}}</td>
                            </tr>
                            <hr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

@endsection
