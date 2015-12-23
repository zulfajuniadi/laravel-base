@extends('app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    {!! app('menu')->handler('model-names.panel-buttons.create')->render('inline') !!}
                    <h4>
                        {{$parentName->name}}: {{trans('model-names.create_new_model_name')}}
                    </h4>
                </div>
                {!! Former::open(action('ModelNamesController@store', ['parent_names' => $parentName->getSlug()])) !!}
                <div class="panel-body">
                    @include('model-names.form')
                </div>
                <div class="panel-footer">
                    <button class="btn btn-primary">{{trans('model-names.submit')}}</button>
                </div>
                {!! Former::close() !!}
            </div>
        </div>
    </div>
</div>
@endsection
