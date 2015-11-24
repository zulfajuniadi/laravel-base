<?php

use App\Repositories\PermissionGroupsRepository;
use App\Repositories\PermissionsRepository;
use App\Repositories\ModelNamesRepository;
use Illuminate\Database\Seeder;
use App\PermissionGroup;
use App\Permission;
use App\ModelName;

class ModelNameSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('model_names')->truncate();

        $modelNames = [];

        foreach ($modelNames as $modelNameData) {
            ModelNamesRepository::create(new ModelName, $modelNameData);
        }

        $permissionGroup = PermissionGroupsRepository::create(new PermissionGroup, ['name' => 'Model Names']);

        $permissionGroup->permissions()->saveMany(array_map(function($permissionData){
            return new Permission($permissionData);
        }, [
            ['name' => 'ModelName:List', 'display_name' => 'List Model Name'],
            ['name' => 'ModelName:Show', 'display_name' => 'View Model Name Details'],
            ['name' => 'ModelName:Create', 'display_name' => 'Create New Model Name'],
            ['name' => 'ModelName:Update', 'display_name' => 'Update Existing Model Name'],
            ['name' => 'ModelName:Duplicate', 'display_name' => 'Duplicate Existing Model Name'],
            ['name' => 'ModelName:Revisions', 'display_name' => 'View Revisions For Model Name'],
            ['name' => 'ModelName:Delete', 'display_name' => 'Delete Existing Model Name'],
        ]));
    }
}
