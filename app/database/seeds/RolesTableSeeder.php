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
        'name' => 'User Admin'
      ],
      [
        'name' => 'User'
      ]
    ];

    $permissions = [
      1 => [],
      2 => [1,2,3,4],
      3 => [5,6,7,8],
      4 => [9,10,11,12]
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