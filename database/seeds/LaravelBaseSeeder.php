<?php

use App\Repositories\PermissionGroupsRepository;
use App\Repositories\PermissionsRepository;
use App\Repositories\UsersRepository;
use App\Repositories\RolesRepository;
use Illuminate\Database\Seeder;
use App\PermissionGroup;
use App\Permission;
use App\User;
use App\Role;

class LaravelBaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('role_user')->truncate();
        DB::table('permission_role')->truncate();
        DB::table('users')->truncate();
        DB::table('roles')->truncate();
        DB::table('permissions')->truncate();
        DB::table('permission_groups')->truncate();
        DB::table('password_resets')->truncate();
        DB::table('auth_logs')->truncate();
        DB::table('user_blacklists')->truncate();

        $roles = [
            [
                'id' => 1,
                'name' => 'Admin',
                'display_name' => 'Admin',
                'description' => 'System Administrator. Can do everything.'
            ]
        ];

        foreach ($roles as $roleData) {
            RolesRepository::create(new Role, $roleData);
        }

        $users = [
            [
                'id' => 1,
                'name' => 'Admin',
                'email' => 'admin@example.com',
                'password' => 'admin',
                'is_active' => true
            ]
        ];

        foreach ($users as $userData) {
            $userData['password'] = app()->make('hash')->make($userData['password']);
            $user = UsersRepository::create(new User, $userData);
        }

        User::find(1)->attachRole(1);

        $permissionGroups = [
            [
                'name' => 'Auth Logs'
            ],
            [
                'name' => 'Permissions and Roles'
            ],
            [
                'name' => 'Users'
            ],
        ];

        foreach ($permissionGroups as $permissionGroupData) {
            PermissionGroupsRepository::create(new PermissionGroup, $permissionGroupData);
        }

        $permissions = [
            ['1', 'AuthLog:List', 'Lists Auth Logs'],
            ['2', 'PermissionGroup:List', 'List Permission Groups'],
            ['2', 'Permission:List', 'List Permissions'],
            ['2', 'Role:List', 'List Role'],
            ['2', 'Role:Show', 'View Role Details'],
            ['2', 'Role:Create', 'Create New Role'],
            ['2', 'Role:Update', 'Update Existing Roles'],
            ['2', 'Role:Duplicate', 'Duplicate Existing Role'],
            ['2', 'Role:Revisions', 'View Role Revisions'],
            ['2', 'Role:Delete', 'Delete Role'],
            ['3', 'User:List', 'List Users'],
            ['3', 'User:Show', 'View User Details'],
            ['3', 'User:Create', 'Create New User'],
            ['3', 'User:Update', 'Update New User'],
            ['3', 'User:Duplicate', 'Duplicate Existing User'],
            ['3', 'User:Revisions', 'View User Revisions'],
            ['3', 'User:Delete', 'Delete Existing User'],
            ['3', 'User:Assume', 'Login As Another User'],
            ['3', 'User:Activate', 'Set User Active / Inactive'],
        ];

        foreach ($permissions as $permissionData) {
            PermissionsRepository::create(new Permission, [
                'permission_group_id' => $permissionData[0],
                'name' => $permissionData[1],
                'display_name' => $permissionData[2],
            ]);
        }

        $permissionGroup = PermissionGroupsRepository::create(new PermissionGroup, ['name' => 'User Blacklists']);

        $permissionGroup->permissions()->saveMany(array_map(function($permissionData){
            return new Permission($permissionData);
        }, [
            ['name' => 'UserBlacklist:List', 'display_name' => 'List User Blacklist'],
            ['name' => 'UserBlacklist:Show', 'display_name' => 'View User Blacklist Details'],
            ['name' => 'UserBlacklist:Create', 'display_name' => 'Create New User Blacklist'],
            ['name' => 'UserBlacklist:Update', 'display_name' => 'Update Existing User Blacklist'],
            ['name' => 'UserBlacklist:Duplicate', 'display_name' => 'Duplicate Existing User Blacklist'],
            ['name' => 'UserBlacklist:Revisions', 'display_name' => 'View Revisions For User Blacklist'],
            ['name' => 'UserBlacklist:Delete', 'display_name' => 'Delete Existing User Blacklist'],
        ]));

    }
}
