@extends('layouts.default')
@section('content')
    <h2>{{$report->name}}</h2>
    <hr>
    @include('reports.filters')

    @if(!isset($response))
        <div class="alert alert-info">Choose some filters above then click "Generate" or "Download".</div>
    @elseif(count($response) > 0)
        <?php $table_columns = $report->columns()->orderBy('order')->get(); ?>
        @foreach ($response as $table_name => $table_data)
            @if(is_string($table_name))
                <h3>{{$table_name}}</h3>
            @endif
            @include('reports.table')
            <hr>
        @endforeach
    @else
        <div class="alert alert-warning">No data that matches your query found.</div>
    @endif
@stop