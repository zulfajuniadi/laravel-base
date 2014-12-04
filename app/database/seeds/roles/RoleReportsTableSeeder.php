<?php

class RoleReportsTableSeeder extends Seeder {

	public function run()
	{

        $roles = [
            [
            'name' => 'Report Admin'
            ]
        ];

        $permissions = [
            [
                'name' => 'Report:list',
                'display_name' => 'List Reports',
                'group_name' => 'Report'
            ],
            [
                'name' => 'Report:show',
                'display_name' => 'Show Report',
                'group_name' => 'Report'
            ],
            [
                'name' => 'Report:create',
                'display_name' => 'Create New Report',
                'group_name' => 'Report'
            ],
            [
                'name' => 'Report:edit',
                'display_name' => 'Edit Existing Report',
                'group_name' => 'Report'
            ],
            [
                'name' => 'Report:delete',
                'display_name' => 'Delete Existing Report',
                'group_name' => 'Report'
            ]
        ];
        
        $createdPermissions = [];

        foreach($permissions as $permission)
        {
            $created = Permission::create($permission);
            $createdPermissions[] = $created->id;
        }

        foreach($roles as $role)
        {
            $created = Role::create($role);
            $created->perms()->sync($createdPermissions);
        }
     }

}