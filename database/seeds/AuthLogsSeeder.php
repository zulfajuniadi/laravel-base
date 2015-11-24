<?php

use Illuminate\Database\Seeder;
use App\Repositories\AuthLogsRepository;
use App\AuthLog;

class AuthLogSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('auth_logs')->truncate();

        $authLogs = [];

        foreach ($authLogs as $authLogData) {
            AuthLogsRepository::create(new AuthLog, $authLogData);
        }
    }
}
