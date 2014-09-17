<?php

class RoleUploadsTableSeeder extends Seeder
{

    public function run()
    {

        Upload::truncate();

        $roles = [
            [
                'name' => 'Upload Admin'
            ]
        ];

        foreach ($roles as $role) {
            $created = Role::create($role);
        }
    }

}
