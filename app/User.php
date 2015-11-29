<?php

namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Cviebrock\EloquentSluggable\SluggableInterface;
use Cviebrock\EloquentSluggable\SluggableTrait;
use Zizaco\Entrust\Traits\EntrustUserTrait;
use Venturecraft\Revisionable\RevisionableTrait;

class User extends Model implements AuthenticatableContract,
                                    CanResetPasswordContract,
                                    SluggableInterface
{
    use Authenticatable,
        CanResetPassword,
        SluggableTrait,
        RevisionableTrait,
        EntrustUserTrait;

    protected $revisionEnabled = true;
    protected $revisionCleanup = true;
    protected $historyLimit = 100;
    protected $revisionCreationsEnabled = true;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 
        'email', 
        'password',
        'avatar_url',
        'is_active'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token'];

    public function getRevisionFormattedFieldNames()
    {
        return [
            'name'       => trans('users.name'),
            'email'      => trans('users.email'),
            'password'   => trans('users.password'),
            'avatar_url' => trans('users.avatar'),
            'is_active'  => trans('users.is_active'),
        ];
    }

    public function getRevisionFormattedFields()
    {
        return [
            'is_active' => 'boolean:' . trans('users.inactive') . '|' . trans('users.active'),
        ];
    }

    public function scopeOptions()
    {
        return static::orderBy('name')->lists('name', 'id');
    }

    public function status()
    {
        if($blacklist = $this->getActiveBlacklist()) {
            return trans('users.blacklisted_until', ['until' => $blacklist->until]);
        }
        return $this->is_active ? trans('users.active') : trans('users.inactive');
    }

    public function getActiveBlacklist()
    {
        return $this->blacklists()->where('until', '>', date('Y-m-d H:i:s'))->first();
    }

    public function blacklists()
    {
        return $this->hasMany(UserBlacklist::class, 'user_id');
    }

    public function getAvatarUrl()
    {
        if($this->avatar_url)
            return $this->avatar_url;
        else 
            return app('identicon')->getImageDataUri($this->email, 128);
    }

    public static function boot()
    {
        parent::boot();
    }
}
