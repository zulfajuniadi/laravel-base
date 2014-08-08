<?php

class PermissionsTableSeeder extends Seeder
{

    public function run()
    {

        Permission::truncate();

        $datas = [
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

        foreach ($datas as $data) {
            Permission::create($data);
        }
    }

}
