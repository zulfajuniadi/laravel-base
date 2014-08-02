<?php

class RoleUploadsTableSeeder extends Seeder {

	public function run()
	{

    Upload::truncate();

    $roles = [
      [
        'name' => 'Upload Admin'
      ]
    ];

		$permissions = [
       [
        'name' => 'Upload:list',
        'display_name' => 'List Uploads',
      ],
      [
        'name' => 'Upload:show',
        'display_name' => 'Show Upload',
      ],
      [
        'name' => 'Upload:create',
        'display_name' => 'Create New Upload',
      ],
      [
        'name' => 'Upload:edit',
        'display_name' => 'Edit Existing Upload',
      ],
      [
        'name' => 'Upload:delete',
        'display_name' => 'Delete Existing Upload',
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