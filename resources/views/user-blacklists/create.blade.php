@extends('app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    {!! app('menu')->handler('user-blacklists.panel-buttons.create')->render('inline') !!}
                    <h4>
                        {{trans('user-blacklists.create_new_user_blacklist')}}: {{$user->name}}
                    </h4>
                </div>
                {!! Former::open(action('UserBlacklistsController@store', $user->slug)) !!}
                <div class="panel-body">
                    @include('user-blacklists.form')
                </div>
                <div class="panel-footer">
                    <button class="btn btn-primary">{{trans('user-blacklists.submit')}}</button>
                </div>
                {!! Former::close() !!}
            </div>
        </div>
    </div>
</div>
@endsection
