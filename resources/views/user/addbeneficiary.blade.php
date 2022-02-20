@extends('user.master')
@section('content')
<style>
button.dt-button, div.dt-button, a.dt-button, button.dt-button:focus:not(.disabled), div.dt-button:focus:not(.disabled), a.dt-button:focus:not(.disabled), button.dt-button:active:not(.disabled), button.dt-button.active:not(.disabled), div.dt-button:active:not(.disabled), div.dt-button.active:not(.disabled), a.dt-button:active:not(.disabled), a.dt-button.active:not(.disabled) {
    background-color: blue;
    /* border-color: #01a9ac; */
    border-radius: 2px;
    color: #fff;
    background-image: none;
    font-size: 17px;
    padding: 4px;
}
.dataTables_wrapper .dataTables_filter {
    float: right;
    text-align: right;
    margin-top: -26px;
}

.btn {
  box-sizing: border-box;
  -webkit-appearance: none;
     -moz-appearance: none;
          appearance: none;
  background-color: transparent;
  border: 2px solid #e74c3c;
  border-radius: 0.6em;
  color: #e74c3c;
  cursor: pointer;
  display: -webkit-box;
  display: -webkit-flex;
  display: -ms-flexbox;
  display: flex;
  -webkit-align-self: center;
      -ms-flex-item-align: center;
          align-self: center;
  font-size: 12px;
  font-weight: 400;
  line-height: 1;
  padding: 12px 12px;
  text-decoration: none;
  text-align: center;
  text-transform: uppercase;
  font-family: 'Montserrat', sans-serif;
  font-weight: 700;
}
.btn:hover, .btn:focus {
  color: #fff;
  outline: 0;
  background-color: blue;
}

</style>
<div class="row">
    <div class="col-sm-12">
        <h2>Add Beneficiary</h2><br>
        <h3 style="font-weight:bold; color:red;">You Already Added One Beneficiary<br>

            If You Want More Beneficiary Added Contact too Admin</h3>
 
    </div>
</div>

<script>
    function confirmAction($url,$msg)
    {
        if(confirm($msg))
        {
            document.location.href=$url;
        }
    }
</script>
@endsection
