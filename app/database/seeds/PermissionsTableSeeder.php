<?php

class PermissionsTableSeeder extends Seeder {

	public function run()
	{

    Permission::truncate();

		$datas = [
      [
        'name' => 'roles:view',
        'display_name' => 'View Roles',
      ],
      [
        'name' => 'roles:create',
        'display_name' => 'Create New Roles',
      ],
      [
        'name' => 'roles:edit',
        'display_name' => 'Edit Existing Roles',
      ],
      [
        'name' => 'roles:delete',
        'display_name' => 'Delete Existing Roles',
      ],
      [
        'name' => 'permissions:view',
        'display_name' => 'View Permissions',
      ],
      [
        'name' => 'permissions:create',
        'display_name' => 'Create New Permissions',
      ],
      [
        'name' => 'permissions:edit',
        'display_name' => 'Edit Existing Permissions',
      ],
      [
        'name' => 'permissions:delete',
        'display_name' => 'Delete Existing Permissions',
      ],
      [
        'name' => 'organization_units:view',
        'display_name' => 'View Organization Units',
      ],
      [
        'name' => 'organization_units:create',
        'display_name' => 'Create New Organization Units',
      ],
      [
        'name' => 'organization_units:edit',
        'display_name' => 'Edit Existing Organization Units',
      ],
      [
        'name' => 'organization_units:delete',
        'display_name' => 'Delete Existing Organization Units',
      ],
      [
        'name' => 'users:view',
        'display_name' => 'View Users',
      ],
      [
        'name' => 'users:create',
        'display_name' => 'Create New Users',
      ],
      [
        'name' => 'users:edit',
        'display_name' => 'Edit Existing Users',
      ],
      [
        'name' => 'users:delete',
        'display_name' => 'Delete Existing Users',
      ]
    ];

		foreach($datas as $data)
		{
			Permission::create($data);
		}
	}

}