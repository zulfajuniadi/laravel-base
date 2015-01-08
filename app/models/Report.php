<?php

class Report extends Ardent {

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
        'is_json',
        'model',
        'path',

    ];

    /**
    * These attributes excluded from the model's JSON form.
    * @var array
    */
    protected $hidden = [
    // 'password'
    ];

    public $fieldTypes = [
        1 => 'Checkbox',
        2 => 'Date Range',
        4 => 'Radio',
        5 => 'Select',
        6 => 'Textbox',
    ];

    /**
    * Validation Rules
    */
    private static $_rules = [
        'store' => [
            'name' => 'required',
            'is_json' => 'required',
            'model' => 'required',
            'path' => 'required',

        ],
        'update' => [
            'name' => 'required',
            'is_json' => 'required',
            'model' => 'required',
            'path' => 'required',

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
        return (Auth::user() && Auth::user()->ability(['Admin', 'Report Admin'], ['Report:list']));
    }

    public static function canCreate() 
    {
        return (Auth::user() && Auth::user()->ability(['Admin', 'Report Admin'], ['Report:create']));
    }

    public function canShow()
    {
        $user = Auth::user();
        if(Auth::user() && Auth::user()->ability(['Admin', 'Report Admin'], ['Report:show']))
            return true;
        return false;
    }

    public function canUpdate() 
    {
        $user = Auth::user();
        if(Auth::user() && Auth::user()->ability(['Admin', 'Report Admin'], ['Report:edit']))
            return true;
        return false;
    }

    public function canDelete() 
    {
        $user = Auth::user();
        if(Auth::user() && Auth::user()->ability(['Admin', 'Report Admin'], ['Report:delete']))
            return true;
        return false;
    }

    /**
    * Relationships
    */
   
    public function fields()
    {
        return $this->hasMany('ReportField');
    }
   
    public function eagers()
    {
        return $this->hasMany('ReportEager');
    }
   
    public function columns()
    {
        return $this->hasMany('ReportColumn');
    }
   
    public function groupings()
    {
        return $this->hasMany('ReportGrouping');
    }
   
    public function sortings()
    {
        return $this->hasMany('ReportSorting');
    }


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


    /**
     * Next Field
     */
    
    public function nextFieldOrder()
    {
        $fields = $this->fields->lists('order');
        if(count($fields) > 0)
            $max = max($this->fields->lists('order'));    
        else
            $max = 0;
        return ($max + 1);
    }
    
    public function nextColumnOrder()
    {
        $columns = $this->columns->lists('order');
        if(count($columns) > 0)
            $max = max($this->columns->lists('order'));    
        else
            $max = 0;
        return ($max + 1);
    }

    public function availableFields($include_eagers = true)
    {
        $columns = [];
        $model = app($this->model);
        $model_table = $model->getTable();
        foreach (Schema::getColumnListing($model->getTable()) as $column) {
            $columns[$model_table][$column] = $column;
        }
        if($include_eagers) {
            foreach ($this->eagers->lists('name') as $relationship_string) {
                $temp_model = $model;
                foreach (explode('.', $relationship_string) as $relationship) {
                    $temp_model = $temp_model->$relationship()->getRelated();
                }
                foreach (Schema::getColumnListing($temp_model->getTable()) as $column) {
                    $columns[$relationship_string][$relationship_string . '#' . $column] = $column;
                }
            }
        }
        return $columns;
    }

    static function fieldTypes()
    {
        return self::$fieldTypes;
    }

    public static function boot()
    {
        parent::boot();

        // self::created(function(){
        //     Cache::tags('Report')->flush();
        // });

        // self::updated(function(){
        //     Cache::tags('Report')->flush();
        // });

        // self::deleted(function(){
        //     Cache::tags('Report')->flush();
        // });
    }
}
