<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class LaravelBaseMigrations extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		$this->down();
		Schema::create('password_reminders', function($table)
		{
			$table->string('email');
			$table->string('token');
			$table->timestamp('created_at')->nullable();

			// Indexes
			$table->index('email');
			$table->index('token');
		});

		Schema::create('users', function($table)
		{
			$table->increments('id');
			$table->string('first_name');
			$table->string('last_name');
			$table->string('username');
			$table->string('email');
			$table->string('password');
			$table->string('confirmation_code')->nullable();
			$table->boolean('confirmed')->default(false);
			$table->string('remember_token')->nullable();
			$table->timestamps();

			// Indexes
			$table->unique('username');
			$table->unique('email');
		});

		Schema::create('roles', function($table)
		{
			$table->increments('id');
			$table->string('name');
			$table->timestamps();
		});

		Schema::create('permissions', function($table)
		{
			$table->increments('id');
			$table->string('name');
			$table->string('group_name');
			$table->string('display_name');
			$table->timestamps();
		});

		Schema::create('assigned_roles', function($table)
		{
			$table->increments('id');
			$table->integer('user_id')->unsigned();
			$table->integer('role_id')->unsigned();

			// Indexes
			$table->index('user_id');
			$table->index('role_id');

			// Foreign Keys
			$table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
			$table->foreign('role_id')->references('id')->on('roles')->onDelete('cascade');
		});

		Schema::create('permission_role', function($table)
		{
			$table->increments('id');
			$table->integer('permission_id')->unsigned();
			$table->integer('role_id')->unsigned();

			// Indexes
			$table->index('permission_id');
			$table->index('role_id');

			// Foreign Keys
			$table->foreign('role_id')->references('id')->on('roles')->onDelete('cascade');
			$table->foreign('permission_id')->references('id')->on('permissions')->onDelete('cascade');
		});

		Schema::create('uploads', function($table)
		{
			$table->increments('id');
			$table->string('name');
			$table->integer('size')->unsigned();
			$table->string('url');
			$table->string('path');
			$table->string('token')->nullable();
			$table->string('type')->nullable();
			$table->string('uploadable_type')->nullable();
			$table->integer('uploadable_id')->unsigned()->nullable();
			$table->integer('user_id')->unsigned();
			$table->timestamps();

			// Indexes
			$table->index('user_id');
			$table->index('uploadable_id');

			// Foreign Keys
			$table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
		});

		Schema::create('reports', function($table)
		{
			$table->increments('id');
			$table->string('name');
			$table->string('model')->nullable();
			$table->string('path')->nullable();
			$table->boolean('is_json')->default(false);
			$table->timestamps();
		});

		Schema::create('report_columns', function($table)
		{
			$table->increments('id');
			$table->integer('report_id')->unsigned();
			$table->integer('order')->default(0);
			$table->string('name');
			$table->string('label')->nullable();
			$table->text('mutator')->nullable();
			$table->text('options')->nullable();
			$table->timestamps();

			// Indexes
			$table->index('report_id');

			// Foreign
			$table->foreign('report_id')->references('id')->on('reports')->onDelete('cascade');
		});

		Schema::create('report_groupings', function($table)
		{
			$table->increments('id');
			$table->integer('report_id')->unsigned();
			$table->string('name');
			$table->string('label')->nullable();
			$table->text('title_function')->nullable();
			$table->integer('sql_function');
			$table->timestamps();

			// Indexes
			$table->index('report_id');

			// Foreign
			$table->foreign('report_id')->references('id')->on('reports')->onDelete('cascade');
		});

		Schema::create('report_fields', function($table)
		{
			$table->increments('id');
			$table->integer('report_id')->unsigned();
			$table->string('name');
			$table->string('label')->nullable();
			$table->string('type')->nullable();
			$table->text('options')->nullable();
			$table->integer('order')->default(0);
			$table->string('default')->nullable();
			$table->timestamps();

			// Indexes
			$table->index('report_id');

			// Foreign
			$table->foreign('report_id')->references('id')->on('reports')->onDelete('cascade');
		});

		Schema::create('report_eagers', function($table)
		{
			$table->increments('id');
			$table->integer('report_id')->unsigned();
			$table->string('name');
			$table->timestamps();

			// Indexes
			$table->index('report_id');

			// Foreign
			$table->foreign('report_id')->references('id')->on('reports')->onDelete('cascade');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('password_reminders');
		Schema::dropIfExists('uploads');
		Schema::dropIfExists('assigned_roles');
		Schema::dropIfExists('permission_role');
		Schema::dropIfExists('roles');
		Schema::dropIfExists('permissions');
		Schema::dropIfExists('users');
		Schema::dropIfExists('report_columns');
		Schema::dropIfExists('report_groupings');
		Schema::dropIfExists('report_fields');
		Schema::dropIfExists('report_eagers');
		Schema::dropIfExists('reports');
	}

}
