<?php
foreach($meta['sections'] as $name => $fields) {

    echo Former::legend($name);

    foreach ($fields as $key => $conf) {

        $field = Former::text($key);

        if($conf['label'])
            $field->label($conf['label']);

        if(isset($configs[$name][$key]))
            $field->value($configs[$name][$key]);
        else if($conf['default'])
            $field->value($conf['default']);

        if(isset($show))
            $field->disabled()->readonly();
        elseif($field->required)
            $field->required;

        echo $field;
    }

}
