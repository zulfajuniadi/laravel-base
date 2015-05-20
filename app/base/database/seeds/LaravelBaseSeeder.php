<?php

class LaravelBaseSeeder extends Seeder
{

    public function run()
    {
        /**
         * Truncate Tables
         */
        
        Permission::truncate();
        Role::truncate();
        User::truncate();
        DB::table('assigned_roles')->truncate();
        DB::table('permission_role')->truncate();

        /**
         * Seed Datas
         */
        
        $permissions = [
            [
                'name'         => 'Role:list',
                'display_name' => 'List Roles',
                'group_name'   => 'Role'
            ],
            [
                'name'         => 'Role:show',
                'display_name' => 'Show Role',
                'group_name'   => 'Role'
            ],
            [
                'name'         => 'Role:create',
                'display_name' => 'Create New Role',
                'group_name'   => 'Role'
            ],
            [
                'name'         => 'Role:edit',
                'display_name' => 'Edit Existing Role',
                'group_name'   => 'Role'
            ],
            [
                'name'         => 'Role:delete',
                'display_name' => 'Delete Existing Role',
                'group_name'   => 'Role'
            ],
            [
                'name'         => 'Permission:list',
                'display_name' => 'List Permissions',
                'group_name'   => 'Permission'
            ],
            [
                'name'         => 'Permission:show',
                'display_name' => 'Show Permission',
                'group_name'   => 'Permission'
            ],
            [
                'name'         => 'User:list',
                'display_name' => 'List Users',
                'group_name'   => 'Users'
            ],
            [
                'name'         => 'User:show',
                'display_name' => 'Show User',
                'group_name'   => 'Users'
            ],
            [
                'name'         => 'User:create',
                'display_name' => 'Create New User',
                'group_name'   => 'Users'
            ],
            [
                'name'         => 'User:edit',
                'display_name' => 'Edit Existing User',
                'group_name'   => 'Users'
            ],
            [
                'name'         => 'User:delete',
                'display_name' => 'Delete Existing User',
                'group_name'   => 'Users'
            ],
            [
                'name'         => 'User:set_confirmation',
                'display_name' => 'Set Existing User\'s Confirmed Status',
                'group_name'   => 'Users'
            ],
            [
                'name'         => 'User:set_password',
                'display_name' => 'Set Existing User\'s Password',
                'group_name'   => 'Users'
            ]
        ];

        $roles = [
            [
                'name' => 'Admin'
            ],
            [
                'name' => 'User'
            ],
            [
                'name' => 'Report Admin'
            ],
            [
                'name' => 'ACL Admin'
            ]
        ];

        $users = [
            [
                'first_name'            => 'System',
                'last_name'             => 'Administrator',
                'username'              => 'admin',
                'email'                 => 'admin@example.com',
                'password'              => 'admin',
                'password_confirmation' => 'admin',
                'confirmed'             => 1,
            ],
            [
                'first_name'            => 'System',
                'last_name'             => 'User',
                'username'              => 'user',
                'email'                 => 'user@example.com',
                'password'              => 'user',
                'password_confirmation' => 'user',
                'confirmed'             => 1,
            ]
        ];

        $user_roles = [
            1 => [1],
            2 => [2]
        ];

        /**
         * Insert Into DB
         */
        
        foreach ($permissions as $data) {
            Permission::create($data);
        }

        foreach ($roles as $data) {
            Role::create($data);
        }

        foreach ($users as $data) {
            $user = User::create($data);
            if(isset($user_roles[$user->id]))
                $user->roles()->sync($user_roles[$user->id]);
        }

    }

}
