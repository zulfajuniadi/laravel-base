<?php namespace App;

use Cviebrock\EloquentSluggable\SluggableInterface;
use Venturecraft\Revisionable\RevisionableTrait;
use Cviebrock\EloquentSluggable\SluggableTrait;
use Illuminate\Database\Eloquent\Model;

class ModelName extends Model implements SluggableInterface {

    use SluggableTrait;
    use RevisionableTrait;

    protected $revisionEnabled = true;
    protected $revisionCleanup = true;
    protected $historyLimit = 100;
    protected $revisionCreationsEnabled = true;

    protected $fillable = [
FILLABLECOLUMN
    ];
    public function getRevisionFormattedFieldNames()
    {
        return [
REVISIONABLENAME
        ];
    }

    public function getRevisionFormattedFields()
    {
        return [
REVISIONABLEVALUE
        ];
    }

    public function scopeOptions()
    {
        return static::orderBy('name')->lists('name', 'id');
    }

FKMODELMETHODS

    public static function boot()
    {
        parent::boot();
    }

}
