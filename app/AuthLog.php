<?php namespace App;

use Venturecraft\Revisionable\RevisionableTrait;
use Illuminate\Database\Eloquent\Model;

class AuthLog extends Model {

    use RevisionableTrait;

    protected $revisionEnabled = true;
    protected $revisionCleanup = true;
    protected $historyLimit = 100;
    protected $revisionCreationsEnabled = true;

    protected $fillable = [
        'user_id',
        'ip_address',
        'action',
    ];
    public function getRevisionFormattedFieldNames()
    {
        return [
            'user_id'  => trans('auth_logs.user_id'),
            'ip_address'  => trans('auth_logs.ip_address'),
            'action'  => trans('auth_logs.action'),
        ];
    }

    public function getRevisionFormattedFields()
    {
        return [
            'User'  => 'string:%s',
            'IP Address'  => 'string:%s',
            'Action'  => 'string:%s',
        ];
    }

    public function scopeOptions()
    {
        return static::orderBy('name')->lists('name', 'id');
    }

    public function user() {
        return $this->belongsTo(User::class, 'user_id');
    }

    public static function boot()
    {
        parent::boot();
    }

}
