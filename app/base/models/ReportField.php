<?php

class ReportField extends Ardent {

    protected $connection = 'reports';

    /**
    * Fillable columns
    */
    protected $fillable = [
        'name',
        'label',
        'report_id',
        'order',
        'type',
        'options',
        'default',
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
            'type' => 'required',
            // 'options' => 'required',
            // 'default' => 'required',

        ],
        'update' => [
            'name' => 'required',
            'label' => 'required',
            // 'report_id' => 'required',
            'order' => 'required',
            'type' => 'required',
            // 'options' => 'required',
            // 'default' => 'required',
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
        return (Auth::user() && Auth::user()->ability(['Admin', 'Report Admin'], ['ReportField:list']));
    }

    public static function canCreate() 
    {
        return (Auth::user() && Auth::user()->ability(['Admin', 'Report Admin'], ['ReportField:create']));
    }

    public function canShow()
    {
        $user = Auth::user();
        if(Auth::user() && Auth::user()->ability(['Admin', 'Report Admin'], ['ReportField:show']))
            return true;
        return false;
    }

    public function canUpdate() 
    {
        $user = Auth::user();
        if(Auth::user() && Auth::user()->ability(['Admin', 'Report Admin'], ['ReportField:edit']))
            return true;
        return false;
    }

    public function canDelete() 
    {
        $user = Auth::user();
        if(Auth::user() && Auth::user()->ability(['Admin', 'Report Admin'], ['ReportField:delete']))
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
        //     Cache::tags('ReportField')->flush();
        // });

        // self::updated(function(){
        //     Cache::tags('ReportField')->flush();
        // });

        // self::deleted(function(){
        //     Cache::tags('ReportField')->flush();
        // });
    }
}
