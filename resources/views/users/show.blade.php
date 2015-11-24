@extends('app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    {!! app('menu')->handler('users.panel-buttons.show')->render('inline') !!}
                    <h4>
                        {{trans('users.view_user', ['name' => $user->name])}}
                    </h4>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <dl class="col-md-6">
                            <dt>{{trans('users.name')}}</dt>
                            <dd>{{$user->name}}</dd>
                        </dl>
                        <dl class="col-md-6">
                            <dt>{{trans('users.email')}}</dt>
                            <dd>{{$user->email}}</dd>
                        </dl>
                        <dl class="col-md-6">
                            <dt>{{trans('users.avatar_url')}}</dt>
                            <dd>{{$user->avatar_url}}</dd>
                        </dl>
                        <dl class="col-md-6">
                            <dt>{{trans('users.is_active')}}</dt>
                            <dd>{{$user->status()}}</dd>
                        </dl>
                        <dl class="col-md-6">
                            <dt>{{trans('roles.roles')}}</dt>
                            <dd>{{implode(', ', $user->roles()->lists('name')->toArray())}}</dd>
                        </dl>
                        <dl class="col-md-6">
                            <dt>{{trans('users.created_at')}}</dt>
                            <dd>{{$user->created_at}}</dd>
                        </dl>
                        <dl class="col-md-6">
                            <dt>{{trans('users.updated_at')}}</dt>
                            <dd>{{$user->updated_at}}</dd>
                        </dl>
                    </div>
                </div>
                <div class="panel-footer">
                    {!! app('menu')->handler('users.record-buttons.show')->render('inline') !!}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
