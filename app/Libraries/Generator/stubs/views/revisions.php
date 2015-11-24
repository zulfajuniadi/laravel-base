@extends('app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    {!! app('menu')->handler('model-names.panel-buttons.revisions')->render('inline') !!}
                    <h4>
                        {{trans('model-names.view_revisions', ['name' => $modelName->name])}}
                    </h4>
                </div>
                <div class="panel-body">

                    <dl class="timeline">
                    @foreach($modelName->revisionHistory->reverse() as $history)
                        @if($history->key == 'created_at' && !$history->old_value)
                            <dt class="create">{{ $history->userResponsible() ? $history->userResponsible()->name : 'System' }} <div class="text-muted">{{ $history->created_at->diffForHumans() }}</div></dt>
                            <dd>{{trans('model-names.created_this')}}</dd>
                        @else
                            <dt>{{ $history->userResponsible() ? $history->userResponsible()->name : 'System' }} <div class="text-muted">{{ $history->created_at->diffForHumans() }}</div></dt>
                            <dd>{{trans('model-names.changed_from_to', [
                                'field' => $history->fieldName(),
                                'from' => $history->oldValue(),
                                'to' => $history->newValue()
                            ])}}</dd>
                        @endif
                    @endforeach
                    </dl>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
