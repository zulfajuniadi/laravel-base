@extends('app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    {!! app('menu')->handler('auth-logs.panel-buttons.edit')->render('inline') !!}
                    <h4>
                        {{trans('auth-logs.update_auth_log', ['name' => $authLog->name])}}
                    </h4>
                </div>
                {!! Former::open(action('AuthLogsController@update', $authLog->getSlug())) !!}
                {!! Former::populate($authLog) !!}
                    {!! Former::hidden('_method', 'PUT') !!}
                <div class="panel-body">
                    @include('auth-logs.form')
                </div>
                <div class="panel-footer">
                    <button class="btn btn-primary">{{trans('auth-logs.submit')}}</button>
                    {!! app('menu')->handler('auth-logs.record-buttons.edit')->render('inline') !!}
                    <div class="clearfix"></div>
                </div>
                {!! Former::close() !!}
            </div>
        </div>
    </div>
</div>
@endsection
