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
        OrganizationUnit::truncate();


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
                'name'         => 'Permission:create',
                'display_name' => 'Create New Permission',
                'group_name'   => 'Permission'
            ],
            [
                'name'         => 'Permission:edit',
                'display_name' => 'Edit Existing Permission',
                'group_name'   => 'Permission'
            ],
            [
                'name'         => 'Permission:delete',
                'display_name' => 'Delete Existing Permission',
                'group_name'   => 'Permission'
            ],
            [
                'name'         => 'OrganizationUnit:list',
                'display_name' => 'List Organization Units',
                'group_name'   => 'Organization Units'
            ],
            [
                'name'         => 'OrganizationUnit:show',
                'display_name' => 'Show Organization Unit',
                'group_name'   => 'Organization Units'
            ],
            [
                'name'         => 'OrganizationUnit:create',
                'display_name' => 'Create New Organization Unit',
                'group_name'   => 'Organization Units'
            ],
            [
                'name'         => 'OrganizationUnit:edit',
                'display_name' => 'Edit Existing Organization Unit',
                'group_name'   => 'Organization Units'
            ],
            [
                'name'         => 'OrganizationUnit:delete',
                'display_name' => 'Delete Existing Organization Unit',
                'group_name'   => 'Organization Units'
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
            ],
            [
                'name' => 'Upload Admin'
            ]
        ];

        $role_permissions = [
            1 => [],
            2 => [1, 2, 3, 4, 5],
            3 => [6, 7, 8, 9, 10],
            4 => [11, 12, 13, 14, 15],
            5 => [16, 17, 18, 19, 20, 21, 22]
        ];

        $users = [
            [
                'first_name'            => 'System',
                'last_name'             => 'Administrator',
                'username'              => 'admin',
                'email'                 => 'admin@example.com',
                'password'              => 'admin',
                'password_confirmation' => 'admin',
                'organization_unit_id'  => 1,
                'confirmed'             => 1,
            ],
            [
                'first_name'            => 'System',
                'last_name'             => 'User',
                'username'              => 'user',
                'email'                 => 'user@example.com',
                'password'              => 'user',
                'password_confirmation' => 'user',
                'organization_unit_id'  => 1,
                'confirmed'             => 1,
            ]
        ];

        $user_roles = [
            1 => [1],
            2 => [6]
        ];

        $organization_units = [
            [
                'name'    => 'Base Group',
                'user_id' => 1
            ]
        ];

        foreach ($organization_units as $data) {
            OrganizationUnit::create($data);
        }


        /**
         * Insert Into DB
         */
        
        foreach ($permissions as $data) {
            Permission::create($data);
        }

        foreach ($roles as $data) {
            $role       = Role::create($data);
            $permission = isset($role_permissions[$role->id])?$role_permissions[$role->id]:null;
            if ($permission)
                $role->perms()->sync($permission);
        }

        foreach ($users as $data) {
            $user = User::create($data);
            if(isset($user_roles[$user->id]))
                $user->roles()->sync($user_roles[$user->id]);
        }

    }

}
