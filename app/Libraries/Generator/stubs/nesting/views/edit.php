@extends('app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    {!! app('menu')->handler('model-names.panel-buttons.edit')->render('inline') !!}
                    <h4>
                        {{$parentName->name}}: {{trans('model-names.update_model_name', ['name' => $modelName->name])}}
                    </h4>
                </div>
                {!! Former::open(action('ModelNamesController@update', ['parent_names' => $parentName->getSlug(), 'model_names' => $modelName->getSlug()])) !!}
                {!! Former::populate($modelName) !!}
                    {!! Former::hidden('_method', 'PUT') !!}
                    <div class="panel-body">
                        @include('model-names.form')
                    </div>
                    <div class="panel-footer">
                        <button class="btn btn-primary">{{trans('model-names.submit')}}</button>
                        {!! app('menu')->handler('model-names.record-buttons.edit')->render('inline') !!}
                        <div class="clearfix"></div>
                    </div>
                {!! Former::close() !!}
            </div>
        </div>
    </div>
</div>
@endsection
