<form action="{{action('ReportController@postShow', $report->path)}}" method="post">
    <div class="well well-sm">
        <?php $fields = $report->fields()->orderBy('order')->get() ?>
        @if(count($fields) > 0)
        <div>
            <h4>Query Filters</h4>
            <br>
        </div>
            @foreach($fields as $index => $field)
            @if($index % 3 === 0)
                <div class="row">
            @endif
            <div class="col-md-4">
                <label class="title" for="{{$field->name}}">{{$field->label}}</label>
                <br>
                <?php
                    $input = '';
                    switch ($field->type) {
                        case 1:
                            try {
                                $options = eval('return ' . $field->options . ';');
                            } catch (Exception $e) {
                                $options = [];
                            }
                            foreach ($options as $id => $name) {
                                $checked = false;
                                $field_name = $field->id . '|' . $field->name;
                                if(isset($form_input[$field_name]) && in_array($id, $form_input[$field_name]))
                                    $checked = true;
                                $input .= '<label>' . Form::checkbox($field_name . '[]', $id, $checked) . ' ' . $name . '</label><br />';
                            }
                            break;
                        case 2:
                            $from_field_name = $field->id . '|' . $field->name . '|from';
                            $to_field_name = $field->id . '|' . $field->name . '|to';
                            $from_value = (isset($form_input[$from_field_name])) ? $form_input[$from_field_name] : date('Y-m') . '-01';
                            $to_value = (isset($form_input[$to_field_name])) ? $form_input[$to_field_name] : '';
                            $input = '<input class="form-control datepicker date-range-from" value="' . $from_value . '" placeholder="From" type="text" id="' . $from_field_name . '" name="' . $from_field_name . '"> - <input class="form-control datepicker date-range-to" value="' . $to_value . '" type="text" placeholder="To" id="' . $to_field_name . '" name="' . $to_field_name . '">';
                            break;
                        case 4:
                            try {
                                $options = eval('return ' . $field->options . ';');
                            } catch (Exception $e) {
                                $options = [];
                            }
                            foreach ($options as $id => $name) {
                                $checked = false;
                                $field_name = $field->id . '|' . $field->name;
                                if(isset($form_input[$field_name]) && $id == $form_input[$field_name])
                                    $checked = true;
                                $input .= '<label>' . Form::radio($field->id . '|' . $field->name, $id, $checked) . ' ' . $name . '</label><br />';
                            }
                            break;
                        case 5:
                            try {
                                $options = eval('return ' . $field->options . ';');
                            } catch (Exception $e) {
                                $options = [];
                            }
                            $field_name = $field->id . '|' . $field->name;
                            $value = (isset($form_input[$field_name])) ? $form_input[$field_name] : null;
                            $input = Form::select($field_name, $options, $value, ['class' => 'form-control', 'id' => $field_name, 'placeholder' => 'Choose One', 'data-value' => $value]);
                            break;
                        case 6:
                            $field_name = $field->id . '|' . $field->name;
                            $value = (isset($form_input[$field_name])) ? $form_input[$field_name] : '';
                            $input = '<input class="form-control" value="' . $value . '" type="text" id="' . $field_name . '" name="' . $field_name . '">';
                            break;
                    }
                    echo $input;
                ?>
            </div>
            @if($index % 3 === 2 && $index !== (count($fields) - 1))
                </div><br>
            @endif
            @endforeach
            </div><br>
        @endif
        <div class="clearfix"></div>
        @if($report->groupings()->count() > 0)
            <div class="row">
                <div class="col-md-4">
                    <div>
                        <h4>Query Grouping</h4>
                    </div>
                    <br>
                    <?php $value = (isset($form_input['grouping'])) ? $form_input['grouping'] : null ?>
                    {{Form::select('grouping', $report->groupings()->lists('label', 'id'), $value, ['class' => 'form-control', 'id' => 'grouping', 'placeholder' => 'Choose One', 'data-value' => $value])}}
                </div>
            </div>
        @endif
    </div>
    <input type="submit" name="operation" value="Generate" class="btn btn-primary">
    <input type="submit" name="operation" value="Download" class="btn btn-info">
    <button id="reset-form" type="button" class="btn btn-default">Reset</button>
</form>
<hr>