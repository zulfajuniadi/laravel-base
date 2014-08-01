<?php

class UsersTableSeeder extends Seeder {

	public function run()
	{
    
    User::truncate();

		$datas = [
      [
        'username' => 'admin',
        'email' => 'admin@example.com',
        'password' => 'admin',
        'password_confirmation' => 'admin',
        'confirmed' => 1,
      ],
      [
        'username' => 'user',
        'email' => 'user@example.com',
        'password' => 'user',
        'password_confirmation' => 'user',
        'confirmed' => 1,
      ]
    ];

    $roles = [
      1 => [1,2],
      2 => [1]
    ];

		foreach($datas as $data)
		{
			$user = User::create($data);
      $user->roles()->sync($roles[$user->id]);
		}
	}

}