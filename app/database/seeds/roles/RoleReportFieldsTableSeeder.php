<?php

class RoleReportFieldsTableSeeder extends Seeder {

	public function run()
	{

        $roles = [
            [
            'name' => 'ReportField Admin'
            ]
        ];

        $permissions = [
            [
                'name' => 'ReportField:list',
                'display_name' => 'List Report Fields',
                'group_name' => 'Report Field'
            ],
            [
                'name' => 'ReportField:show',
                'display_name' => 'Show Report Field',
                'group_name' => 'Report Field'
            ],
            [
                'name' => 'ReportField:create',
                'display_name' => 'Create New Report Field',
                'group_name' => 'Report Field'
            ],
            [
                'name' => 'ReportField:edit',
                'display_name' => 'Edit Existing Report Field',
                'group_name' => 'Report Field'
            ],
            [
                'name' => 'ReportField:delete',
                'display_name' => 'Delete Existing Report Field',
                'group_name' => 'Report Field'
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