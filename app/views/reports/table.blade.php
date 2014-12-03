<table class="table tbl-bordered tbl-striped tbl-hover">
    <thead>
        <tr>
        @foreach ($table_columns as $column)
            <th>{{$column->label}}</th>
        @endforeach
        </tr>
    </thead>
    <tbody>
    @foreach ($table_data as $table_row)
        <tr>
            @foreach ($table_columns as $column)
                <td>{{$column->getContent($table_row)}}</td>
            @endforeach
        </tr>
    @endforeach
    </tbody>
    <tfoot>
        <tr>
            <td colspan="{{$table_columns->count()}}" style="text-right">Total Rows: {{count($table_data)}}</td>
        </tr>
    </tfoot>
</table>