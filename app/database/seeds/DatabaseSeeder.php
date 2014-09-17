<?php

class DatabaseSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        Eloquent::unguard();
        DB::select('SET FOREIGN_KEY_CHECKS=0');
        $this->call('PermissionsTableSeeder');
        $this->call('RolesTableSeeder');
        $this->call('UsersTableSeeder');
        $this->call('OrganizationUnitsTableSeeder');
        $this->call('RoleUploadsTableSeeder');
        DB::select('SET FOREIGN_KEY_CHECKS=1');
        // $this->call('');

    }

}
