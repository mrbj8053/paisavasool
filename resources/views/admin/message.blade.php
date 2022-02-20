@if(Session::has('msgAdmin'))
<div class="alert alert-success background-success">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <i class="icofont icofont-close-line-circled text-white"></i>
    </button>
    <strong>{{ Session::get('msgAdmin') }}</strong>
    </div>
@elseif(Session::has('errorAdmin'))
<div class="alert alert-success background-danger">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <i class="icofont icofont-close-line-circled text-white"></i>
    </button>
    <strong>{{ Session::get('errorAdmin') }}</strong>
    </div>
@endif
