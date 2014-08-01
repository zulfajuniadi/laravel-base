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

}