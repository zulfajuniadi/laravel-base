<?php

class ReportGrouping extends Ardent {

    protected $connection = 'reports';

    /**
    * Fillable columns
    */
    protected $fillable = [
        'name',
        'report_id',
        'label',
        'title_function',
        'sql_function',
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
            'report_id' => 'required',
            'label' => 'required',

        ],
        'update' => [
            'name' => 'required',
            'report_id' => 'required',
            'label' => 'required',

        ]
    ];

    public static $rules = [];

    public static $sqlFunctions = [
        1 => 'Monthly', 
        2 => 'Annual'
    ];

    public static function setRules($name)
    {
        self::$rules = self::$_rules[$name];
    }

    /**
    * ACL
    */

    public static function canList() 
    {
        return (Auth::user() && Auth::user()->ability(['Admin', 'Report Admin'], ['ReportGrouping:list']));
    }

    public static function canCreate() 
    {
        return (Auth::user() && Auth::user()->ability(['Admin', 'Report Admin'], ['ReportGrouping:create']));
    }

    public function canShow()
    {
        $user = Auth::user();
        if(Auth::user() && Auth::user()->ability(['Admin', 'Report Admin'], ['ReportGrouping:show']))
            return true;
        return false;
    }

    public function canUpdate() 
    {
        $user = Auth::user();
        if(Auth::user() && Auth::user()->ability(['Admin', 'Report Admin'], ['ReportGrouping:edit']))
            return true;
        return false;
    }

    public function canDelete() 
    {
        $user = Auth::user();
        if(Auth::user() && Auth::user()->ability(['Admin', 'Report Admin'], ['ReportGrouping:delete']))
            return true;
        return false;
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
        //     Cache::tags('ReportGrouping')->flush();
        // });

        // self::updated(function(){
        //     Cache::tags('ReportGrouping')->flush();
        // });

        // self::deleted(function(){
        //     Cache::tags('ReportGrouping')->flush();
        // });
    }
}
