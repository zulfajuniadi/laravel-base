@extends('app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    {!! app('menu')->handler('roles.panel-buttons.show')->render('inline') !!}
                    <h4>
                        View Role: {{$role->display_name}}
                    </h4>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <dl class="col-md-6">
                            <dt>System Name</dt>
                            <dd>{{$role->name}}</dd>
                        </dl>
                        <dl class="col-md-6">
                            <dt>Display Name</dt>
                            <dd>{{$role->display_name}}</dd>
                        </dl>
                        <dl class="col-md-6">
                            <dt>Description</dt>
                            <dd>{{$role->name}}</dd>
                        </dl>
                        <dl class="col-md-6">
                            <dt>Created At</dt>
                            <dd>{{$role->created_at}}</dd>
                        </dl>
                        <dl class="col-md-6">
                            <dt>Updated At</dt>
                            <dd>{{$role->updated_at}}</dd>
                        </dl>
                    </div>
                </div>
                <div class="panel-footer">
                    {!! app('menu')->handler('roles.record-buttons.show')->render('inline') !!}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
