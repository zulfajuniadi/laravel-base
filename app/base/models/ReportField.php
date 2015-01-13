<?php

class ReportField extends Ardent {

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
        return (Auth::user() && Auth::user()->ability(['Admin', 'ReportField Admin'], ['ReportField:list']));
    }

    public static function canCreate() 
    {
        return (Auth::user() && Auth::user()->ability(['Admin', 'ReportField Admin'], ['ReportField:create']));
    }

    public function canShow()
    {
        $user = Auth::user();
        if(Auth::user() && Auth::user()->ability(['Admin', 'ReportField Admin'], ['ReportField:show']))
            return true;
        return false;
    }

    public function canUpdate() 
    {
        $user = Auth::user();
        if(Auth::user() && Auth::user()->ability(['Admin', 'ReportField Admin'], ['ReportField:edit']))
            return true;
        return false;
    }

    public function canDelete() 
    {
        $user = Auth::user();
        if(Auth::user() && Auth::user()->ability(['Admin', 'ReportField Admin'], ['ReportField:delete']))
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
