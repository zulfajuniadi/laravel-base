<?php namespace App;

use Zizaco\Entrust\EntrustRole;
use Cviebrock\EloquentSluggable\SluggableInterface;
use Cviebrock\EloquentSluggable\SluggableTrait;
use Venturecraft\Revisionable\RevisionableTrait;

class Role extends EntrustRole implements SluggableInterface {

    use SluggableTrait;
    use RevisionableTrait;

    protected $revisionEnabled = true;
    protected $revisionCleanup = true;
    protected $historyLimit = 100;
    protected $revisionCreationsEnabled = true;

    protected $fillable = [
        'name', 
        'display_name', 
        'description',
    ];

    public function scopeOptions()
    {
        return static::orderBy('name')->lists('name', 'id');
    }

    public static function boot()
    {
        parent::boot();
    }
}
