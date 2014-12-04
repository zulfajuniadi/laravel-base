<?php

class ReportEager extends Ardent {

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
        'report_id',

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

        ],
        'update' => [
            'name' => 'required',
            'report_id' => 'required',

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
        return (Auth::user() && Auth::user()->ability(['Admin', 'ReportEager Admin'], ['ReportEager:list']));
    }

    public static function canCreate() 
    {
        return (Auth::user() && Auth::user()->ability(['Admin', 'ReportEager Admin'], ['ReportEager:create']));
    }

    public function canShow()
    {
        $user = Auth::user();
        if(Auth::user() && Auth::user()->ability(['Admin', 'ReportEager Admin'], ['ReportEager:show']))
            return true;
        return false;
    }

    public function canUpdate() 
    {
        $user = Auth::user();
        if(Auth::user() && Auth::user()->ability(['Admin', 'ReportEager Admin'], ['ReportEager:edit']))
            return true;
        return false;
    }

    public function canDelete() 
    {
        $user = Auth::user();
        if(Auth::user() && Auth::user()->ability(['Admin', 'ReportEager Admin'], ['ReportEager:delete']))
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

        self::created(function(){
            Cache::tags('ReportEager')->flush();
        });

        self::updated(function(){
            Cache::tags('ReportEager')->flush();
        });

        self::deleted(function(){
            Cache::tags('ReportEager')->flush();
        });
    }
}
