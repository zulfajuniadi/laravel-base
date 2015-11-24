@extends('app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    {!! app('menu')->handler('permissions.panel-buttons.edit')->render('inline') !!}
                    <h4>
                        {{trans('permissions.update_permission', ['name' => $permission->name])}}
                    </h4>
                </div>
                {!! Former::open(action('PermissionsController@update', $permission->getSlug())) !!}
                {!! Former::populate($permission) !!}
                    {!! Former::hidden('_method', 'PUT') !!}
                <div class="panel-body">
                    @include('permissions.form')
                </div>
                <div class="panel-footer">
                    <button class="btn btn-primary">{{trans('permissions.submit')}}</button>
                    {!! app('menu')->handler('permissions.record-buttons.edit')->render('inline') !!}
                    <div class="clearfix"></div>
                </div>
                {!! Former::close() !!}
            </div>
        </div>
    </div>
</div>
@endsection
