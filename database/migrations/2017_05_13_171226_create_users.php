<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
		Schema::create('users', function(Blueprint $table) {
			$table->increments('id');
			$table->string('email', 255);
			$table->string('password_hash', 255);
			$table->string('remember_token', 100)->nullable();
			$table->boolean('confirmed')->default(0);
			$table->string('name', 50)->nullable();
			$table->dateTime('created_at');
			$table->dateTime('updated_at');
			
			$table->unique('email');
		});
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('users');
    }
}
