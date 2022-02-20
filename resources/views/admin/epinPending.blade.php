@extends('admin.master')
@section('content')
<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-header">
                <h5>E-Pin Pending</h5>
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
                    @include('admin.message')
                    <p style="color: black;font-weight:600">Generate E-Pins</p>
                    <form action="{{ route('admin.epin.generate') }}" method="POST">
                    @csrf
                    <div class="row pt-3 ml-auto">
                    <div class="form-group col-lg-4">
                    <input required type="number" name="numberpin" value="{{old('numberpin')}}" class="form-control form-txt-primary @error('numberpin') is-invalid @enderror" placeholder="Number of E-Pins">
                    @error('numberpin')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                    </div>
                    <div class="form-group col-lg-4">
                        <select required name="epinType" class="form-control form-txt-primary @error('numberpin') is-invalid @enderror" >
                        <option value="" >Select Pin Type</option>
                        @php
                            $record=userHelper::getPlans();
                        @endphp
                        @foreach ($record as $item)
                        <option value="{{Crypt::encrypt($item->id)}}">{{$item->name." (".$item->entryamount.")"}}</option>
                        @endforeach
                        </select>
                        @error('epinType')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                        </div>
                    <div class="form-group col-lg-4">
                        <button type="submit" class="btn btn-primary m-b-0">Generate</button>
                    </div>
                    </div>
                </form>
                <hr>

                    <p style="color: black;font-weight:600">Transfer E-Pins</p>
                    <p>Total E-Pins Availiable ={{count($epins)}}</p>
                    <form action="{{ route('admin.epin.transfer') }}" method="POST">
                    @csrf
                    <div class="row pt-3 ml-auto">
                    <div class="form-group col-lg-4">
                    <input type="number" name="number" value="{{old('number')}}" class="form-control form-txt-primary @error('number') is-invalid @enderror" placeholder="Number of E-Pins">
                    @error('number')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                    </div>
                    <div class="form-group col-lg-4">
                    <select required name="selectUser" class="form-control form-control-primary @error('selectUser') is-invalid @enderror">
                    <option value="">Tranfer To</option>
                    @foreach ($users as $item)
                    <option value="{{Crypt::encrypt($item->ownid)}}">{{$item->name." (".$item->ownid.")"}}</option>
                    @endforeach
                    </select>
                    @error('selectUser')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                    </div>
                    <div class="form-group col-lg-4">
                        <select required name="epinType" class="form-control form-txt-primary @error('numberpin') is-invalid @enderror" >
                        <option value="" >Select Pin Type</option>
                        @php
                            $record=userHelper::getPlans();
                        @endphp
                        @foreach ($record as $item)
                        <option value="{{Crypt::encrypt($item->id)}}">{{$item->name." (".$item->entryamount.")"}}</option>
                        @endforeach
                        </select>
                        @error('epinType')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                        </div>
                    <div class="form-group col-lg-4">
                        <button type="submit" class="btn btn-primary m-b-0">Transfer</button>
                    </div>
                    </div>
                </form>
                    <div class="">
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-sm-12 col-md-6">
                                    <div class="dataTables_length" id="basic-col-reorder_length"></div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-6">
                                    <div id="basic-col-reorder_filter" class="dataTables_filter"></div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-12 col-sm-12">
                                    <table id="basic-col-reorder" class="table table-striped table-bordered dataTable" role="grid" aria-describedby="basic-col-reorder_info">
                                        <thead>
                                            <tr>
                                                <th>Sr no.</th>
                                                <th>E-Pin</th>
                                                <th>Pin Type</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php
                                                $i=0;
                                            @endphp
                                            @foreach ($epins as $item)
                                            <tr>
                                            <td >{{++$i}}</td>
                                            <td>{{$item->epin}} &nbsp;&nbsp;&nbsp;<a href="javascript:void(0)" title="Copy E-Pin" onclick="copyToClipBoard('{{$item->epin}}')"><i class="fa fa-clone"></i></a></td>
                                            <td>{{userHelper::getPlanDetails($item->planid)->name}}</td>
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
<script>
    function copyToClipBoard($epin)
    {
        var input = document.createElement('input');
    input.setAttribute('value', $epin);
    document.body.appendChild(input);
    input.select();
    var result = document.execCommand('copy');
    document.body.removeChild(input);
    alert('Pin "'+$epin+'" copied to clipboard');
    }
</script>
@endsection
