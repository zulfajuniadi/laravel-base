<?php namespace App;

use Cviebrock\EloquentSluggable\SluggableInterface;
use Venturecraft\Revisionable\RevisionableTrait;
use Cviebrock\EloquentSluggable\SluggableTrait;
use Illuminate\Database\Eloquent\Model;

class UserBlacklist extends Model implements SluggableInterface {

    use SluggableTrait;
    use RevisionableTrait;

    protected $revisionEnabled = true;
    protected $revisionCleanup = true;
    protected $historyLimit = 100;
    protected $revisionCreationsEnabled = true;

    protected $fillable = [
        'user_id',
        'until',
        'name',
    ];
    public function getRevisionFormattedFieldNames()
    {
        return [
            'user_id'  => trans('user-blacklists.user_id'),
            'until'  => trans('user-blacklists.until'),
            'name'  => trans('user-blacklists.name'),
        ];
    }

    public function getRevisionFormattedFields()
    {
        return [
            'User'  => 'string:%s',
            'Until'  => 'string:%s',
            'Reason'  => 'string:%s',
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
