@if(isset($danger) || $danger = Session::get('danger'))
    <div class="container">
        <div class="alert alert-danger alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
            {{{$danger}}}
        </div>
    </div>
@endif
@if(isset($info) || $info = Session::get('info'))
    <div class="container">
        <div class="alert alert-info alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
            {{{$info}}}
        </div>
    </div>
@endif
@if(isset($warning) || $warning = Session::get('warning'))
    <div class="container">
        <div class="alert alert-warning alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
            {{{$warning}}}
        </div>
    </div>
@endif
@if(isset($success) || $success = Session::get('success'))
    <div class="container">
        <div class="alert alert-success alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
            {{{$success}}}
        </div>
    </div>
@endif
