<?php

class PermissionsTableSeeder extends Seeder {

	public function run()
	{

    Permission::truncate();

		$datas = [
      [
        'name' => 'Role:list',
        'display_name' => 'List Roles',
      ],
      [
        'name' => 'Role:show',
        'display_name' => 'Show Role',
      ],
      [
        'name' => 'Role:create',
        'display_name' => 'Create New Role',
      ],
      [
        'name' => 'Role:edit',
        'display_name' => 'Edit Existing Role',
      ],
      [
        'name' => 'Role:delete',
        'display_name' => 'Delete Existing Role',
      ],
      [
        'name' => 'Permission:list',
        'display_name' => 'List Permissions',
      ],
      [
        'name' => 'Permission:show',
        'display_name' => 'Show Permission',
      ],
      [
        'name' => 'Permission:create',
        'display_name' => 'Create New Permission',
      ],
      [
        'name' => 'Permission:edit',
        'display_name' => 'Edit Existing Permission',
      ],
      [
        'name' => 'Permission:delete',
        'display_name' => 'Delete Existing Permission',
      ],
      [
        'name' => 'OrganizationUnit:list',
        'display_name' => 'List Organization Units',
      ],
      [
        'name' => 'OrganizationUnit:show',
        'display_name' => 'Show Organization Unit',
      ],
      [
        'name' => 'OrganizationUnit:create',
        'display_name' => 'Create New Organization Unit',
      ],
      [
        'name' => 'OrganizationUnit:edit',
        'display_name' => 'Edit Existing Organization Unit',
      ],
      [
        'name' => 'OrganizationUnit:delete',
        'display_name' => 'Delete Existing Organization Unit',
      ],
      [
        'name' => 'User:list',
        'display_name' => 'List Users',
      ],
      [
        'name' => 'User:show',
        'display_name' => 'Show User',
      ],
      [
        'name' => 'User:create',
        'display_name' => 'Create New User',
      ],
      [
        'name' => 'User:edit',
        'display_name' => 'Edit Existing User',
      ],
      [
        'name' => 'User:delete',
        'display_name' => 'Delete Existing User',
      ]
    ];

		foreach($datas as $data)
		{
			Permission::create($data);
		}
	}

}