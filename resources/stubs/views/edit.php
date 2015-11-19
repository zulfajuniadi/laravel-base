@extends('app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    {!! app('menu')->handler('roles.panel-buttons.edit')->render('inline') !!}
                    <h4>
                        Update Role: {{$role->display_name}}
                    </h4>
                </div>
                {!! Former::open(action('RolesController@update', $role->getSlug())) !!}
                {!! Former::populate($role) !!}
                    {!! Former::hidden('_method', 'PUT') !!}
                <div class="panel-body">
                    @include('roles.form')
                </div>
                <div class="panel-footer">
                    <button class="btn btn-primary">Submit</button>
                    {!! app('menu')->handler('roles.record-buttons.edit')->render('inline') !!}
                    <div class="clearfix"></div>
                </div>
                {!! Former::close() !!}
            </div>
        </div>
    </div>
</div>
@endsection
