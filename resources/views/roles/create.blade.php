@extends('app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    {!! app('menu')->handler('roles.panel-buttons.create')->render('inline') !!}
                    <h4>
                        {{trans('roles.create_new_role')}}
                    </h4>
                </div>
                {!! Former::open(action('RolesController@store')) !!}
                <div class="panel-body">
                    @include('roles.form')
                </div>
                <div class="panel-footer">
                    <button class="btn btn-primary">{{trans('roles.submit')}}</button>
                </div>
                {!! Former::close() !!}
            </div>
        </div>
    </div>
</div>
@endsection
