@extends('app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    {!! app('menu')->handler('users.panel-buttons')->render('inline') !!}
                    <h4>
                        {{trans('users.edit_profile')}}
                    </h4>
                </div>
                {!! Former::open(action('UsersController@doEditProfile')) !!}
                {!! Former::populate($user) !!}
                <div class="panel-body">
                    @include('users.form')
                </div>
                <div class="panel-footer">
                    <button class="btn btn-primary">{{trans('users.submit')}}</button>
                    <div class="clearfix"></div>
                </div>
                {!! Former::close() !!}
            </div>
        </div>
    </div>
</div>
@endsection
