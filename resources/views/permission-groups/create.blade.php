@extends('app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    {!! app('menu')->handler('permission-groups.panel-buttons.create')->render('inline') !!}
                    <h4>
                        {{trans('permission-groups.create_new_permission_group')}}
                    </h4>
                </div>
                {!! Former::open(action('PermissionGroupsController@store')) !!}
                <div class="panel-body">
                    @include('permission-groups.form')
                </div>
                <div class="panel-footer">
                    <button class="btn btn-primary">{{trans('permission-groups.submit')}}</button>
                </div>
                {!! Former::close() !!}
            </div>
        </div>
    </div>
</div>
@endsection
