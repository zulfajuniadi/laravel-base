@extends('app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    {!! app('menu')->handler('roles.panel-buttons.show')->render('inline') !!}
                    <h4>
                        {{trans('roles.view_role', ['name' => $role->name])}}
                    </h4>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <dl class="col-md-6">
                            <dt>{{trans('roles.name')}}</dt>
                            <dd>{{$role->name}}</dd>
                        </dl>
                        <dl class="col-md-6">
                            <dt>{{trans('roles.display_name')}}</dt>
                            <dd>{{$role->display_name}}</dd>
                        </dl>
                        <dl class="col-md-6">
                            <dt>{{trans('roles.description')}}</dt>
                            <dd>{{$role->description}}</dd>
                        </dl>
                        <dl class="col-md-6">
                            <dt>{{trans('permissions.permissions')}}</dt>
                            <dd>{{implode(', ', $role->perms()->lists('display_name')->toArray()) ?: '&nbsp;'}}</dd>
                        </dl>
                        <dl class="col-md-6">
                            <dt>{{trans('roles.created_at')}}</dt>
                            <dd>{{$role->created_at}}</dd>
                        </dl>
                        <dl class="col-md-6">
                            <dt>{{trans('roles.updated_at')}}</dt>
                            <dd>{{$role->updated_at}}</dd>
                        </dl>
                    </div>
                </div>
                <div class="panel-footer">
                    {!! app('menu')->handler('roles.record-buttons.show')->render('inline') !!}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
