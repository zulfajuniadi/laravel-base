@extends('app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    {!! app('menu')->handler('permission-groups.panel-buttons.edit')->render('inline') !!}
                    <h4>
                        {{trans('permission-groups.update_permission_group', ['name' => $permissionGroup->name])}}
                    </h4>
                </div>
                {!! Former::open(action('PermissionGroupsController@update', $permissionGroup->getSlug())) !!}
                {!! Former::populate($permissionGroup) !!}
                    {!! Former::hidden('_method', 'PUT') !!}
                <div class="panel-body">
                    @include('permission-groups.form')
                </div>
                <div class="panel-footer">
                    <button class="btn btn-primary">{{trans('permission-groups.submit')}}</button>
                    {!! app('menu')->handler('permission-groups.record-buttons.edit')->render('inline') !!}
                    <div class="clearfix"></div>
                </div>
                {!! Former::close() !!}
            </div>
        </div>
    </div>
</div>
@endsection
