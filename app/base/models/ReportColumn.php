<?php

class ReportColumn extends Ardent {

    protected $connection = 'reports';

    /**
    * Fillable columns
    */
    protected $fillable = [
        'name',
        'label',
        'report_id',
        'order',
        'options',
        'mutator',

    ];

    /**
    * These attributes excluded from the model's JSON form.
    * @var array
    */
    protected $hidden = [
    // 'password'
    ];

    /**
    * Validation Rules
    */
    private static $_rules = [
        'store' => [
            'name' => 'required',
            'label' => 'required',
            'report_id' => 'required',
            'order' => 'required',
        ],
        'update' => [
            'name' => 'required',
            'label' => 'required',
            'report_id' => 'required',
            'order' => 'required',
        ]
    ];

    public static $rules = [];

    public static function setRules($name)
    {
        self::$rules = self::$_rules[$name];
    }

    /**
    * ACL
    */

    public static function canList() 
    {
        return (Auth::user() && Auth::user()->ability(['Admin', 'Report Admin'], ['ReportColumn:list']));
    }

    public static function canCreate() 
    {
        return (Auth::user() && Auth::user()->ability(['Admin', 'Report Admin'], ['ReportColumn:create']));
    }

    public function canShow()
    {
        $user = Auth::user();
        if(Auth::user() && Auth::user()->ability(['Admin', 'Report Admin'], ['ReportColumn:show']))
            return true;
        return false;
    }

    public function canUpdate() 
    {
        $user = Auth::user();
        if(Auth::user() && Auth::user()->ability(['Admin', 'Report Admin'], ['ReportColumn:edit']))
            return true;
        return false;
    }

    public function canDelete() 
    {
        $user = Auth::user();
        if(Auth::user() && Auth::user()->ability(['Admin', 'Report Admin'], ['ReportColumn:delete']))
            return true;
        return false;
    }

    public function getContent($table_row)
    {
        $value = '';
        if(stristr($this->name, '#') === false) {
            $value = $table_row->{$this->name};
        } else {
            $columns = explode('#', $this->name);
            $tables = array_reverse(explode('.', $columns[0]));
            $result = [];
            $str = '$result[] = $table_row->' . $columns[1] . ';';
            foreach ($tables as $table) {
                $str = 
                    'if(get_class($table_row) === \'Illuminate\\Database\\Eloquent\\Collection\' || get_class($table_row->' . $table . ') === \'Illuminate\\Database\\Eloquent\\Collection\'){
                        foreach ($table_row->' . $table . ' as $table_row) {
                            ' . $str . '
                        }
                    } else { 
                        try {
                            $table_row = $table_row->' . $table . ';
                            return $result = $table_row->' . $columns[1] . ';
                        } catch (Exception $e) {}
                        ' . $str . '
                    }';
            }
            eval($str);
            if(is_array($result)) {
                array_unique($result);
                $value = array_reduce($result, function($then, $now) use ($columns) {
                    return $then . '<li>' . $now . '</li>';
                }, '<ul>') . '</ul>';
            } else {
                $value = $result;
            }
        }
        if($this->options) {
            $array = eval('return ' . $this->options . ';');
            $value = $array[$value];
        }
        if($this->mutator) {
            $value = eval('return ' . $this->mutator . ';');
        }
        return $value;
    }

    /**
    * Relationships
    */
   
    // public function status()
    // {
    //     return $this->hasOne('Status');
    // }


    /**
    * Decorators
    */

    public function getNameAttribute($value)
    {
        return $value;
    }

    /**
    * Boot Method
    */

    public static function boot()
    {
        parent::boot();

        // self::created(function(){
        //     Cache::tags('ReportColumn')->flush();
        // });

        // self::updated(function(){
        //     Cache::tags('ReportColumn')->flush();
        // });

        // self::deleted(function(){
        //     Cache::tags('ReportColumn')->flush();
        // });
    }
}
