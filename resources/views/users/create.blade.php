@extends('app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    {!! app('menu')->handler('users.panel-buttons.create')->render('inline') !!}
                    <h4>
                        {{trans('users.create_new_user')}}
                    </h4>
                </div>
                {!! Former::open(action('UsersController@store')) !!}
                <div class="panel-body">
                    @include('users.form')
                    {!! Former::select('roles[]')
                        ->label('roles.roles')
                        ->multiple()
                        ->options(App\Role::options()) !!}
                    {!! Former::text('password')
                        ->value(str_random(12))
                        ->label('users.password')
                        ->required() !!}
                </div>
                <div class="panel-footer">
                    <button class="btn btn-primary">{{trans('users.submit')}}</button>
                </div>
                {!! Former::close() !!}
            </div>
        </div>
    </div>
</div>
@endsection
