@extends('app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    {!! app('menu')->handler('permission-groups.panel-buttons.show')->render('inline') !!}
                    <h4>
                        {{trans('permission-groups.view_permission_group', ['name' => $permissionGroup->name])}}
                    </h4>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <dl class="col-md-6">
                            <dt>{{trans('permission-groups.name')}}</dt>
                            <dd>{{$permissionGroup->name}}</dd>
                        </dl>
                        <dl class="col-md-6">
                            <dt>{{trans('permission-groups.created_at')}}</dt>
                            <dd>{{$permissionGroup->created_at}}</dd>
                        </dl>
                        <dl class="col-md-6">
                            <dt>{{trans('permission-groups.updated_at')}}</dt>
                            <dd>{{$permissionGroup->updated_at}}</dd>
                        </dl>
                    </div>
                </div>
                <div class="panel-footer">
                    {!! app('menu')->handler('permission-groups.record-buttons.show')->render('inline') !!}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
