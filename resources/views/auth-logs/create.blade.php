@extends('app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    {!! app('menu')->handler('auth-logs.panel-buttons.create')->render('inline') !!}
                    <h4>
                        {{trans('auth-logs.create_new_auth_log')}}
                    </h4>
                </div>
                {!! Former::open(action('AuthLogsController@store')) !!}
                <div class="panel-body">
                    @include('auth-logs.form')
                </div>
                <div class="panel-footer">
                    <button class="btn btn-primary">{{trans('auth-logs.submit')}}</button>
                </div>
                {!! Former::close() !!}
            </div>
        </div>
    </div>
</div>
@endsection
