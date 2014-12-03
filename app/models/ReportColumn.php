<?php

class ReportColumn extends Ardent {

    /**
    * $show_authorize_flag
    * 0 => all
    * 1 => show mine only
    * 2 => if i'm a head of ou, show all under my ou
    * 3 => if i'm a head of ou, show all under my ou and other entries under his ou's children
    */
    static $show_authorize_flag = 0;

    /**
    * $update_authorize_flag
    * 0 => all
    * 1 => show mine only
    * 2 => if i'm a head of ou, show all under my ou
    * 3 => if i'm a head of ou, show all under my ou and other entries under his ou's children
    */
    static $update_authorize_flag = 0;

    /**
    * $delete_authorize_flag
    * 0 => all
    * 1 => show mine only
    * 2 => if i'm a head of ou, show all under my ou
    * 3 => if i'm a head of ou, show all under my ou and other entries under his ou's children
    */
    static $delete_authorize_flag = 0;

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
        return (Auth::user() && Auth::user()->ability(['Admin', 'ReportColumn Admin'], ['ReportColumn:list']));
    }

    public static function canCreate() 
    {
        return (Auth::user() && Auth::user()->ability(['Admin', 'ReportColumn Admin'], ['ReportColumn:create']));
    }

    public function canShow()
    {
        $user = Auth::user();
        if(Auth::user() && Auth::user()->ability(['Admin', 'ReportColumn Admin'], ['ReportColumn:show']))
            return true;
        return false;
    }

    public function canUpdate() 
    {
        $user = Auth::user();
        if(Auth::user() && Auth::user()->ability(['Admin', 'ReportColumn Admin'], ['ReportColumn:edit']))
            return true;
        return false;
    }

    public function canDelete() 
    {
        $user = Auth::user();
        if(Auth::user() && Auth::user()->ability(['Admin', 'ReportColumn Admin'], ['ReportColumn:delete']))
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
                        } catch (Exception $e) {}
                        ' . $str . '
                    }';
            }
            eval($str);
            array_unique($result);
            $value = array_reduce($result, function($then, $now) use ($columns) {
                return $then . '<li>' . $now . '</li>';
            }, '<ul>') . '</ul>';
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

        self::created(function(){
            Cache::tags('ReportColumn')->flush();
        });

        self::updated(function(){
            Cache::tags('ReportColumn')->flush();
        });

        self::deleted(function(){
            Cache::tags('ReportColumn')->flush();
        });
    }
}
