<?php

class RoleReportGroupingsTableSeeder extends Seeder {

	public function run()
	{

        $roles = [
            [
            'name' => 'ReportGrouping Admin'
            ]
        ];

        $permissions = [
            [
                'name' => 'ReportGrouping:list',
                'display_name' => 'List Report Groupings',
                'group_name' => 'Report Grouping'
            ],
            [
                'name' => 'ReportGrouping:show',
                'display_name' => 'Show Report Grouping',
                'group_name' => 'Report Grouping'
            ],
            [
                'name' => 'ReportGrouping:create',
                'display_name' => 'Create New Report Grouping',
                'group_name' => 'Report Grouping'
            ],
            [
                'name' => 'ReportGrouping:edit',
                'display_name' => 'Edit Existing Report Grouping',
                'group_name' => 'Report Grouping'
            ],
            [
                'name' => 'ReportGrouping:delete',
                'display_name' => 'Delete Existing Report Grouping',
                'group_name' => 'Report Grouping'
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