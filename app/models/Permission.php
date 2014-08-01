<?php

class Permission extends Zizaco\Entrust\EntrustPermission {

  // Add your validation rules here
  public static $rules = [
    'name' => 'required',
    'display_name' => 'required'
  ];

  // Don't forget to fill this array
  protected $fillable = [
    'name',
    'display_name'
  ];

  public static function canList() {
    return true;
  }

  public static function canCreate() {
    return true;
  }

  public function canShow()
  {
    return true;
  }

  public function canUpdate() {
    return true;
  }

  public function canDelete() {
    return true;
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