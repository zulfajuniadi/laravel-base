<?php

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;
use Zizaco\Entrust\HasRole;
use Zizaco\Confide\ConfideUser;

class User extends ConfideUser implements UserInterface, RemindableInterface {

	use UserTrait, RemindableTrait, HasRole;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'users';

  protected $fillable = [
    'username',
    'email',
    'password',
    'confirmation_code',
    'confirmed'
  ];

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = array('password', 'remember_token');

  public function organizationunit()
  {
    return $this->belongsTo('OrganizationUnit', 'organizationunit_id');
  }

  public function get_authorized_userids($authorization_flag)
  {
    if($authorization_flag === 0)
      return [];
    if($authorization_flag === 1)
      return [$this->id];

    $key = implode('.', ['User', 'get_authorized_userids', $this->id, $authorization_flag]);
    $user = $this;
    return Cache::tags(['User', 'OrganizationUnit'])->rememberForever($key, function() use ($authorization_flag, $user) {
      $result = [$user->id];
      if($user->organizationunit->user_id === $user->id) { 
        if($authorization_flag == 2) {
          $result = $user->organizationunit->users->lists('id');
        }
        if($authorization_flag == 3) {
          $result = User::whereIn('organizationunit_id', $user->organizationunit->descendantsAndSelf()->get()->lists('id'))->lists('id');
        }
      }
      return $result;
    });
  }

  public function is_authorized($authorization_flag, $user_id)
  {
    if($authorization_flag == 0) {
      return true;
    }
    $users = get_authorized_userids($authorization_flag);
    return in_array($user_id, $users);
  }

  public static function boot()
  {
    parent::boot();

    static::created(function(){
      Cache::tags('User')->flush();
    });

    static::updated(function(){
      Cache::tags('User')->flush();
    });

    static::deleted(function(){
      Cache::tags('User')->flush();
    });
  }

}
