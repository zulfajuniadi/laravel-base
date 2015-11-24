<?php namespace App;

use Cviebrock\EloquentSluggable\SluggableInterface;
use Venturecraft\Revisionable\RevisionableTrait;
use Cviebrock\EloquentSluggable\SluggableTrait;
use Illuminate\Database\Eloquent\Model;

class PermissionGroup extends Model implements SluggableInterface {

    use SluggableTrait;
    use RevisionableTrait;

    protected $revisionEnabled = true;
    protected $revisionCleanup = true;
    protected $historyLimit = 100;
    protected $revisionCreationsEnabled = true;

    protected $fillable = [
        'name',
    ];

    public function scopeOptions()
    {
        return static::orderBy('name')->lists('name', 'id');
    }

    public function permissions()
    {
        return $this->hasMany(Permission::class, 'permission_group_id');
    }

    public static function boot()
    {
        parent::boot();
    }

}
