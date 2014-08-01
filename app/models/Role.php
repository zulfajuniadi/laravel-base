<?php

class Role extends Zizaco\Entrust\EntrustRole {

  // Add your validation rules here
  public static $rules = [
    'name' => 'required'
  ];

  // Don't forget to fill this array
  protected $fillable = [
    'name',
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