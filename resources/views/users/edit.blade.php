@extends('app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    {!! app('menu')->handler('users.panel-buttons.edit')->render('inline') !!}
                    <h4>
                        {{trans('users.update_user', ['name' => $user->name])}}
                    </h4>
                </div>
                {!! Former::open(action('UsersController@update', $user->getSlug())) !!}
                {!! Former::populate($user) !!}
                    {!! Former::hidden('_method', 'PUT') !!}
                <div class="panel-body">
                    @include('users.form')
                    {!! Former::select('roles[]')
                        ->label('roles.roles')
                        ->select($user->roles->lists('id'))
                        ->multiple()
                        ->options(App\Role::options()) !!}
                </div>
                <div class="panel-footer">
                    <button class="btn btn-primary">{{trans('users.submit')}}</button>
                    {!! app('menu')->handler('users.record-buttons.edit')->render('inline') !!}
                    <div class="clearfix"></div>
                </div>
                {!! Former::close() !!}
            </div>
        </div>
    </div>
</div>
@endsection
