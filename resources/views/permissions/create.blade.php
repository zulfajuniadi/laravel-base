@extends('app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    {!! app('menu')->handler('permissions.panel-buttons.create')->render('inline') !!}
                    <h4>
                        {{trans('permissions.create_new_permission')}}
                    </h4>
                </div>
                {!! Former::open(action('PermissionsController@store')) !!}
                <div class="panel-body">
                    @include('permissions.form')
                </div>
                <div class="panel-footer">
                    <button class="btn btn-primary">{{trans('permissions.submit')}}</button>
                </div>
                {!! Former::close() !!}
            </div>
        </div>
    </div>
</div>
@endsection
