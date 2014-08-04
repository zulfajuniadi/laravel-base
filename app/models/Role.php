<?php

class Role extends Zizaco\Entrust\EntrustRole {

  /**
   * Validation Rules
   */
  private static $_rules = [
    'store' => [
      'name' => 'required|unique:roles,name'
    ],
    'update' => [
      'name' => 'required|unique:roles,name'
    ]
  ];

  public static $rules = [];

  public static function setRules($name)
  {
    self::$rules = self::$_rules[$name];
  }

  // Don't forget to fill this array
  protected $fillable = [
    'name',
  ];

  public static function canList() {
    return (Auth::user() && Auth::user()->ability(['Admin', 'Role Admin'], ['Role:list']));
  }

  public static function canCreate() {
    return (Auth::user() && Auth::user()->ability(['Admin', 'Role Admin'], ['Role:create']));
  }

  public function canShow()
  {
    return (Auth::user() && Auth::user()->ability(['Admin', 'Role Admin'], ['Role:show']));
  }

  public function canUpdate() {
    return (Auth::user() && Auth::user()->ability(['Admin', 'Role Admin'], ['Role:edit']));
  }

  public function canDelete() {
    return (Auth::user() && Auth::user()->ability(['Admin', 'Role Admin'], ['Role:delete']));
  }

  public static function boot()
  {
    parent::boot();

    static::created(function(){
      Cache::tags('Role')->flush();
    });

    static::updated(function(){
      Cache::tags('Role')->flush();
    });

    static::deleted(function(){
      Cache::tags('Role')->flush();
    });
  }
}