<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePlayersTable extends Migration {

	public function up()
	{
		Schema::create('players', function(Blueprint $table) {
			$table->increments('id');
			$table->string('first');
			$table->string('last');
			$table->string('username');
			$table->string('email');
			$table->tinyInteger('class');
			$table->string('boarder|day');
			$table->string('house')->nullable();
			$table->integer('target_id')->unsigned()->default('0');
			$table->tinyInteger('strikes')->default('0');
			$table->datetime('banned_until')->nullable();
			$table->string('tag_code', 2);
			$table->boolean('tagged')->default('0');
		});
	}

	public function down()
	{
		Schema::drop('players');
	}
}