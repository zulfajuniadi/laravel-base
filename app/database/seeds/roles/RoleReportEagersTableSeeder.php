<?php

class RoleReportEagersTableSeeder extends Seeder {

	public function run()
	{

        $roles = [
            [
            'name' => 'ReportEager Admin'
            ]
        ];

        $permissions = [
            [
                'name' => 'ReportEager:list',
                'display_name' => 'List Report Eagers',
                'group_name' => 'Report Eager'
            ],
            [
                'name' => 'ReportEager:show',
                'display_name' => 'Show Report Eager',
                'group_name' => 'Report Eager'
            ],
            [
                'name' => 'ReportEager:create',
                'display_name' => 'Create New Report Eager',
                'group_name' => 'Report Eager'
            ],
            [
                'name' => 'ReportEager:edit',
                'display_name' => 'Edit Existing Report Eager',
                'group_name' => 'Report Eager'
            ],
            [
                'name' => 'ReportEager:delete',
                'display_name' => 'Delete Existing Report Eager',
                'group_name' => 'Report Eager'
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