<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();
        try {
            DB::statement('SET FOREIGN_KEY_CHECKS=0');
        } catch (Exception $e) {}

        $this->call(LaravelBaseSeeder::class);

        Model::reguard();
        try {
            DB::statement('SET FOREIGN_KEY_CHECKS=1');
        } catch (Exception $e) {}
    }
}
