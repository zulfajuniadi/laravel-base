<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class FKMigrations extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        app('fkmigrator')->up();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        app('fkmigrator')->down();
    }
}
