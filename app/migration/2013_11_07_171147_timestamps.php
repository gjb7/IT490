<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Capsule\Manager as Capsule;

class Timestamps extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Capsule::schema()->table('items', function($table) {
			$table->timestamps();
		});
		
		Capsule::schema()->table('orders', function($table) {
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Capsule::shcema()->table('items', function($table) {
			$table->dropTimestamps();
		});
		
		Capsule::shcema()->table('orders', function($table) {
			$table->dropTimestamps();
		});
	}

}