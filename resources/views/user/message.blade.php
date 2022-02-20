@if(Session::has('msgUser'))
<div class="alert alert-success background-success">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <i class="icofont icofont-close-line-circled text-white"></i>
    </button>
    <strong>{{ Session::get('msgUser') }}</strong>
    </div>
@elseif(Session::has('errorUser'))
<div class="alert alert-success background-danger">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <i class="icofont icofont-close-line-circled text-white"></i>
    </button>
    <strong>{{ Session::get('errorUser') }}</strong>
    </div>
@endif
