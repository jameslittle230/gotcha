<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateForeignKeys extends Migration {

	public function up()
	{
		Schema::table('players', function(Blueprint $table) {
			$table->foreign('target_id')->references('id')->on('players')
						->onDelete('cascade')
						->onUpdate('cascade');
		});
		Schema::table('tags', function(Blueprint $table) {
			$table->foreign('predator')->references('id')->on('players')
						->onDelete('cascade')
						->onUpdate('cascade');
		});
		Schema::table('tags', function(Blueprint $table) {
			$table->foreign('prey')->references('id')->on('players')
						->onDelete('restrict')
						->onUpdate('restrict');
		});
	}

	public function down()
	{
		
	}
}