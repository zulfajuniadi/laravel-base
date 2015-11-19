<?php

use Illuminate\Database\Seeder;
use App\User;
use App\Repositories\UserRepository;
use App\Role;
use App\Repositories\RoleRepository;

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

        $roles = [
            [
                'id' => 1,
                'name' => 'Admin',
                'display_name' => 'Admin',
                'description' => 'System Administrator. Can do everything.'
            ]
        ];

        foreach ($roles as $roleData) {
            RoleRepository::create(new Role, $roleData);
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
            $user = UserRepository::create(new User, $userData);
            UserRepository::setActive($user);
        }

        User::find(1)->attachRole(1);

    }
}
