<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTodos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
		Schema::create('todos', function(Blueprint $table) {
			$table->increments('id');
			$table->integer('user_id')->unsigned();
			$table->string('name', 255)->nullable();
			
			$table->foreign('user_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
		});
		
		Schema::create('todo_items', function(Blueprint $table) {
			$table->increments('id');
			$table->integer('todo_id')->unsigned();
			$table->string('description', 255);
			$table->boolean('completed')->default(0);
			
			$table->foreign('todo_id')->references('id')->on('todos')->onDelete('cascade')->onUpdate('cascade');
		});
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
		Schema::drop('todo_items');
        Schema::drop('todos');
    }
}
