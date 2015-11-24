@extends('app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    {!! app('menu')->handler('auth-logs.panel-buttons.show')->render('inline') !!}
                    <h4>
                        {{trans('auth-logs.view_auth_log', ['name' => $authLog->name])}}
                    </h4>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <dl class="col-md-6">
                            <dt>{{trans('auth-logs.user_id')}}</dt>
                            <dd>{{$authLog->user_id}}</dd>
                        </dl>
                        <dl class="col-md-6">
                            <dt>{{trans('auth-logs.ip_address')}}</dt>
                            <dd>{{$authLog->ip_address}}</dd>
                        </dl>
                        <dl class="col-md-6">
                            <dt>{{trans('auth-logs.action')}}</dt>
                            <dd>{{$authLog->action}}</dd>
                        </dl>
                        <dl class="col-md-6">
                            <dt>{{trans('auth-logs.created_at')}}</dt>
                            <dd>{{$authLog->created_at}}</dd>
                        </dl>
                        <dl class="col-md-6">
                            <dt>{{trans('auth-logs.updated_at')}}</dt>
                            <dd>{{$authLog->updated_at}}</dd>
                        </dl>
                    </div>
                </div>
                <div class="panel-footer">
                    {!! app('menu')->handler('auth-logs.record-buttons.show')->render('inline') !!}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
