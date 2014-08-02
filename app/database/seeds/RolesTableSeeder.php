<?php

class RolesTableSeeder extends Seeder {

	public function run()
	{

    Role::truncate();

		$datas = [
      [
        'name' => 'Admin'
      ],
      [
        'name' => 'Role Admin'
      ],
      [
        'name' => 'Permission Admin'
      ],
      [
        'name' => 'OrganizationUnit Admin'
      ],
      [
        'name' => 'User Admin'
      ],
      [
        'name' => 'User'
      ]
    ];

    $permissions = [
      1 => [],
      2 => [1,2,3,4,5],
      3 => [6,7,8,9,10],
      4 => [11,12,13,14,15],
      5 => [16,17,18,19,20,21,22]
    ];

		foreach($datas as $data)
		{
			$role = Role::create($data);
      $permission = isset($permissions[$role->id]) ? $permissions[$role->id] : null;
      if($permission) {
        $role->perms()->sync($permission);
      }
		}
	}

}