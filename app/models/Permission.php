<?php

class Permission extends Zizaco\Entrust\EntrustPermission {

  /**
   * Validation Rules
   */
  private static $_rules = [
    'store' => [
      'name' => 'required|unique:permission,name',
      'display_name' => 'required',
    ],
    'update' => [
      'name' => 'required|unique:permission,name',
      'display_name' => 'required',
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
    'display_name'
  ];

  public static function canList() {
    return (Auth::user() && Auth::user()->ability(['Admin', 'Permission Admin'], ['Permission:list']));
  }

  public static function canCreate() {
    return (Auth::user() && Auth::user()->ability(['Admin', 'Permission Admin'], ['Permission:create']));
  }

  public function canShow()
  {
    return (Auth::user() && Auth::user()->ability(['Admin', 'Permission Admin'], ['Permission:show']));
  }

  public function canUpdate() {
    return (Auth::user() && Auth::user()->ability(['Admin', 'Permission Admin'], ['Permission:edit']));
  }

  public function canDelete() {
    return (Auth::user() && Auth::user()->ability(['Admin', 'Permission Admin'], ['Permission:delete']));
  }

  public static function boot()
  {
    parent::boot();

    static::created(function(){
      Cache::tags('Permission')->flush();
    });

    static::updated(function(){
      Cache::tags('Permission')->flush();
    });

    static::deleted(function(){
      Cache::tags('Permission')->flush();
    });
  }

}