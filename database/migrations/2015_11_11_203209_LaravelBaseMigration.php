<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class LaravelBaseMigration extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        // Create table for storing revisions
        Schema::create('revisions', function ($table) {
            $table->increments('id');
            $table->string('revisionable_type');
            $table->integer('revisionable_id');
            $table->integer('user_id')->nullable();
            $table->string('key');
            $table->text('old_value')->nullable();
            $table->text('new_value')->nullable();
            $table->timestamps();

            $table->index(array('revisionable_id', 'revisionable_type'));
        });

        // Create table for storing permissions
        Schema::create('user_blacklists', function (Blueprint $table) {
            $table->increments('id');
            $table->string('slug');
            $table->integer('user_id')->unsigned();
            $table->integer('blacklisted_by')->unsigned();
            $table->text('reason');
            $table->timestamp('expires_at');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('blacklisted_by')->references('id')->on('users')
                ->onUpdate('cascade')->onDelete('cascade');
        });

        // Create table for storing permissions
        Schema::create('auth_logs', function (Blueprint $table) {
            $table->increments('id');
            $table->string('slug');
            $table->integer('user_id')->unsigned();
            $table->string('ip_address')->nullable();
            $table->string('action');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')
                ->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_blacklists');
        Schema::dropIfExists('auth_logs');
        Schema::dropIfExists('revisions');
    }
}
