@extends('app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    {!! app('menu')->handler('model-names.panel-buttons.show')->render('inline') !!}
                    <h4>
                        {{$parentName->name}}: {{trans('model-names.view_model_name', ['name' => $modelName->name])}}
                    </h4>
                </div>
                <div class="panel-body">
                    <div class="row">
SHOWFIELDS
                        <dl class="col-md-6">
                            <dt>{{trans('model-names.created_at')}}</dt>
                            <dd>{{$modelName->created_at}}</dd>
                        </dl>
                        <dl class="col-md-6">
                            <dt>{{trans('model-names.updated_at')}}</dt>
                            <dd>{{$modelName->updated_at}}</dd>
                        </dl>
                    </div>
                </div>
                <div class="panel-footer">
                    {!! app('menu')->handler('model-names.record-buttons.show')->render('inline') !!}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
