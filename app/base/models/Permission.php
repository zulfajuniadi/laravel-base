<?php

class Permission extends Zizaco\Entrust\EntrustPermission
{

    /**
     * Validation Rules
     */
    static $_rules = [
        'store' => [
            'name'         => 'required|unique:permissions,name',
            'display_name' => 'required',
            'group_name'
        ],
        'update' => [
            'name'         => 'required|unique:permissions,name',
            'display_name' => 'required',
            'group_name'
        ]
    ];

    static $rules = [];

    public static function setRules($name)
    {
        self::$rules = self::$_rules[$name];
    }

    // Don't forget to fill this array
    protected $fillable = [
        'name',
        'display_name',
        'group_name'
    ];

    public static function canList()
    {
        return (Auth::user() && Auth::user()->ability(['Admin', 'ACL Admin'], ['Permission:list']));
    }

    public static function canCreate()
    {
        return false;
    }

    public function canShow()
    {
        return (Auth::user() && Auth::user()->ability(['Admin', 'ACL Admin'], ['Permission:show']));
    }

    public function canUpdate()
    {
        return false;
    }

    public function canDelete()
    {
        return false;
    }

    public static function boot()
    {
        parent::boot();

        // self::created(function () {
        //     Cache::tags('Permission')->flush();
        // });

        // self::updated(function () {
        //     Cache::tags('Permission')->flush();
        // });

        // self::deleted(function () {
        //     Cache::tags('Permission')->flush();
        // });
    }

}
