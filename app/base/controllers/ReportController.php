<?php

class ReportController extends \BaseController {

    public function getShow($path)
    {
        $report = Report::where('path', $path)->first();
        $form_input = [];
        Breadcrumbs::push(action('ReportController@getShow', $report->path), $report->name);
        return View::make('reports.report', compact('report', 'form_input'));
    }

    public function postShow($path)
    {
        $report = Report::where('path', $path)->first();
        $form_input = Input::all();
        $response = [];
        $cached_fields = [];
        $query = app($report->model);
        if(isset($form_input['grouping'])) {
            $grouping = ReportGrouping::findOrFail($form_input['grouping']);
            if(isset($form_input['sorting'])) {
                $column = ReportSorting::findOrFail($form_input['sorting']);
                $dir = 1;
                if(isset($form_input['sorting_dir'])) {
                    $dir = $form_input['sorting_dir'];
                }
                $query = $query->orderBy($column->name, $dir);
            }
            switch ($grouping->sql_function) {
                case 0:
                $groups = $query->groupBy($grouping->name)->select($grouping->name)->get();
                break;
                case 1:
                $groups = $query->groupBy(DB::raw('year(' . $grouping->name . '), month(' . $grouping->name . ')'))->select(DB::raw('year(' . $grouping->name . ') as "year(' . $grouping->name . ')"') , DB::raw('month(' . $grouping->name . ') as "month(' . $grouping->name . ')"'))->get();
                break;
                case 2:
                $groups = $query->groupBy(DB::raw('year(' . $grouping->name . ')'))->select(DB::raw('year(' . $grouping->name . ') as "year(' . $grouping->name . ')"'))->get();
                break;
            }
        } else {
            $groups = ['nogroup'];
        }
        foreach ($groups as $index => $wheres) {
            $query = app($report->model);
            $eagers = ReportEager::where('report_id', $report->id)->lists('name');
            foreach ($eagers as $eager) {
                $query = $query->with($eager);
            }
            if($wheres !== 'nogroup') {
                foreach ($wheres->toArray() as $key => $value) {
                    $query = $query->where(DB::raw($key), $value);
                }
            }
            $update_query = function($query, $field, $configs, $input) {
                switch ($field->type) {
                    case 1:
                    $query = $query->whereIn($configs[1], $input);
                    break;
                    case 2:
                    if($configs[2] == 'from' && strlen($input) > 0)
                        $query = $query->where($configs[1], '>=', $input);
                    if($configs[2] == 'to' && strlen($input) > 0)
                        $query = $query->where($configs[1], '<=', $input);
                    break;
                    case 4:
                    case 5:
                    $query = $query->where($configs[1], $input);
                    break;
                    case 6:
                    if(strlen($input) > 0)
                        $query = $query->where($configs[1], 'like', '%' . $input . '%');
                    break;
                }
                return $query;
            };
            foreach ($form_input as $name => $value) {
                if(stristr($name, '|') !== false) {
                    $configs = explode('|', $name);
                    if(!isset($cached_fields[$configs[0]])) {
                        $cached_fields[$configs[0]] = ReportField::findOrFail($configs[0]);
                    }
                    $field = $cached_fields[$configs[0]]; 
                    if(stristr($field->name, '#') === false) {
                        $query = $update_query($query, $field, $configs, $value);
                    } else {
                        $tables_string = explode('#', $configs[1]);
                        $tables = array_reverse(explode('.', $tables_string[0]));
                        $configs[1] = $tables_string[1];
                        $str = '$table = $query->getModel()->getTable();' . "\r\n" . '$configs[1] = $table . "." . $configs[1];' . "\r\n" . '$update_query($query, $field, $configs, $value);';
                        foreach ($tables as $table) {
                            $str = '$query->whereHas("' . $table . '", function($query) use ($update_query, $field, $configs, $value) {' . "\r\n" . $str . "\r\n" . '});';
                        }
                        $query  = eval('return ' . $str);
                    }
                }
            }
            if(isset($form_input['sorting'])) {
                $column = ReportSorting::findOrFail($form_input['sorting']);
                $dir = 1;
                if(isset($form_input['sorting_dir'])) {
                    $dir = $form_input['sorting_dir'];
                }
                $query = $query->orderBy($column->name, $dir);
            }
            if($query->count() > 0) {
                if(isset($form_input['grouping'])) {
                    $grouping = ReportGrouping::findOrFail($form_input['grouping']);
                    switch ($grouping->sql_function) {
                        case 0:
                        $response[array_values($wheres->toArray())[0]] = $query->get();
                        break;
                        case 1:
                        $dates = array_reverse($wheres->toArray());
                        $response[implode(' - ',$dates)] = $query->get();
                        break;
                        case 2:
                        $year = (array_values($wheres->toArray())[0]) . ' ';
                        $response[$year] = $query->get();
                        break;
                    }
                } else {
                    $response[] = $query->get();
                }
            }
        }
        if(Request::ajax())
            return $response;

        if($form_input['operation'] === 'Download') {
            return Excel::create($report->name . '__' . date('Ymd-his'), function($excel) use ($response, $report) {
                foreach ($response as $index => $table) {
                    $sheet_name = 'default';
                    if(is_string($index)) {
                        $sheet_name = $index;
                    }
                    $excel->sheet($sheet_name, function($sheet) use ($table, $report, $response) {
                        $sheet->loadView('reports.table', [
                            'table_columns' => $report->columns,
                            'table_data'    => $table
                        ]);
                    });
                }
            })->download();	
        }
        return View::make('reports.report', compact('report', 'response', 'form_input'));
    }

    public function __construct()
    {
        parent::__construct();
        Asset::push('js', 'reports');
        Asset::push('css', 'reports');
    }

}