@extends('app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    {!! app('menu')->handler('user-blacklists.panel-buttons.edit')->render('inline') !!}
                    <h4>
                        {{trans('user-blacklists.update_user_blacklist', ['name' => $userBlacklist->name])}}: {{$user->name}}
                    </h4>
                </div>
                {!! Former::open(action('UserBlacklistsController@update', [$user->slug, $userBlacklist->getSlug()])) !!}
                {!! Former::populate($userBlacklist) !!}
                    {!! Former::hidden('_method', 'PUT') !!}
                <div class="panel-body">
                    @include('user-blacklists.form')
                </div>
                <div class="panel-footer">
                    <button class="btn btn-primary">{{trans('user-blacklists.submit')}}</button>
                    {!! app('menu')->handler('user-blacklists.record-buttons.edit')->render('inline') !!}
                    <div class="clearfix"></div>
                </div>
                {!! Former::close() !!}
            </div>
        </div>
    </div>
</div>
@endsection
