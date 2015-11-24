<?php namespace App;

use Cviebrock\EloquentSluggable\SluggableInterface;
use Venturecraft\Revisionable\RevisionableTrait;
use Cviebrock\EloquentSluggable\SluggableTrait;
use Illuminate\Database\Eloquent\Model;
use Zizaco\Entrust\EntrustPermission;

class Permission extends EntrustPermission implements SluggableInterface {

    use SluggableTrait;
    use RevisionableTrait;

    protected $revisionEnabled = true;
    protected $revisionCleanup = true;
    protected $historyLimit = 100;
    protected $revisionCreationsEnabled = true;

    protected $fillable = [
        'permission_group_id',
        'name',
        'display_name',
    ];

    public function scopeOptions()
    {
        return PermissionGroup::with('permissions')->orderBy('name')->get()->reduce(function($carry, $permissionGroup){
            $carry[$permissionGroup->name] = $permissionGroup->permissions->lists('display_name', 'id')->toArray();
            return $carry;
        }, []);
    }

    public function permission_group() {
        return $this->belongsTo(PermissionGroup::class, 'permission_group_id');
    }

    public function roles() {
        return $this->belongsToMany(Role::class);
    }

    public static function boot()
    {
        parent::boot();
    }

}
