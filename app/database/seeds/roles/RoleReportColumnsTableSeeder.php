<?php

class RoleReportColumnsTableSeeder extends Seeder {

	public function run()
	{

        $roles = [
            [
            'name' => 'ReportColumn Admin'
            ]
        ];

        $permissions = [
            [
                'name' => 'ReportColumn:list',
                'display_name' => 'List Report Columns',
                'group_name' => 'Report Column'
            ],
            [
                'name' => 'ReportColumn:show',
                'display_name' => 'Show Report Column',
                'group_name' => 'Report Column'
            ],
            [
                'name' => 'ReportColumn:create',
                'display_name' => 'Create New Report Column',
                'group_name' => 'Report Column'
            ],
            [
                'name' => 'ReportColumn:edit',
                'display_name' => 'Edit Existing Report Column',
                'group_name' => 'Report Column'
            ],
            [
                'name' => 'ReportColumn:delete',
                'display_name' => 'Delete Existing Report Column',
                'group_name' => 'Report Column'
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