@extends('app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    {!! app('menu')->handler('users.panel-buttons')->render('inline') !!}
                    <h4>
                        {{trans('users.change_password')}}
                    </h4>
                </div>
                {!! Former::open(action('UsersController@doChangePassword')) !!}
                <div class="panel-body">
                    {!! Former::password('existing_password')
                        ->label('users.existing_password')
                        ->required() !!}
                    {!! Former::password('password')
                        ->label('users.password')
                        ->required() !!}
                    {!! Former::password('password_confirmation')
                        ->label('users.confirm_password')
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
@section('scripts')
    <script type="text/javascript">
        $('#password').keyup(function(event){
            $('#password_confirmation')[0].pattern = event.target.value;
        });
    </script>
@endsection
