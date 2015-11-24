@extends('app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    {!! app('menu')->handler('user-blacklists.panel-buttons.show')->render('inline') !!}
                    <h4>
                        {{trans('user-blacklists.view_user_blacklist', ['name' => $userBlacklist->name])}}
                    </h4>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <dl class="col-md-6">
                            <dt>{{trans('user-blacklists.user_id')}}</dt>
                            <dd>{{$userBlacklist->user->name}}</dd>
                        </dl>
                        <dl class="col-md-6">
                            <dt>{{trans('user-blacklists.until')}}</dt>
                            <dd>{{$userBlacklist->until}}</dd>
                        </dl>
                        <dl class="col-md-6">
                            <dt>{{trans('user-blacklists.name')}}</dt>
                            <dd>{{$userBlacklist->name}}</dd>
                        </dl>
                        <dl class="col-md-6">
                            <dt>{{trans('user-blacklists.created_at')}}</dt>
                            <dd>{{$userBlacklist->created_at}}</dd>
                        </dl>
                        <dl class="col-md-6">
                            <dt>{{trans('user-blacklists.updated_at')}}</dt>
                            <dd>{{$userBlacklist->updated_at}}</dd>
                        </dl>
                    </div>
                </div>
                <div class="panel-footer">
                    {!! app('menu')->handler('user-blacklists.record-buttons.show')->render('inline') !!}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
