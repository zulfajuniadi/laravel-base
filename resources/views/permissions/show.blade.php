@extends('app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    {!! app('menu')->handler('permissions.panel-buttons.show')->render('inline') !!}
                    <h4>
                        {{trans('permissions.view_permission', ['name' => $permission->name])}}
                    </h4>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <dl class="col-md-6">
                            <dt>{{trans('permissions.permission_group_id')}}</dt>
                            <dd>{{$permission->permission_group_id}}</dd>
                        </dl>
                        <dl class="col-md-6">
                            <dt>{{trans('permissions.name')}}</dt>
                            <dd>{{$permission->name}}</dd>
                        </dl>
                        <dl class="col-md-6">
                            <dt>{{trans('permissions.display_name')}}</dt>
                            <dd>{{$permission->display_name}}</dd>
                        </dl>
                        <dl class="col-md-6">
                            <dt>{{trans('permissions.created_at')}}</dt>
                            <dd>{{$permission->created_at}}</dd>
                        </dl>
                        <dl class="col-md-6">
                            <dt>{{trans('permissions.updated_at')}}</dt>
                            <dd>{{$permission->updated_at}}</dd>
                        </dl>
                    </div>
                </div>
                <div class="panel-footer">
                    {!! app('menu')->handler('permissions.record-buttons.show')->render('inline') !!}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
