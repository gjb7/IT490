<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Capsule\Manager as Capsule;

class CreateTables extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Capsule::schema()->create('customers', function ($table) {
			$table->increments('id');
			$table->string('first_name');
			$table->string('last_name');
			$table->string('address');
			$table->string('city');
			$table->string('state');
			$table->string('zip');
			$table->timestamps();
		});
		
		Capsule::schema()->create('items', function ($table) {
			$table->increments('id');
			$table->string('name')->unique();
			$table->integer('quantity');
			$table->decimal('price', 10, 2);
		});
		
		Capsule::schema()->create('orders', function ($table) {
			$table->increments('id');
			$table->integer('customer_id')->unsigned();
			$table->decimal('amount_due', 10, 2);
			$table->foreign('customer_id')->references('id')->on('customers')->onDelete('cascade');
		});
		
		Capsule::schema()->create('item_order', function ($table) {
			$table->integer('order_id')->unsigned();
			$table->integer('item_id')->unsigned();
			$table->foreign('order_id')->references('id')->on('orders');
			$table->foreign('item_id')->references('id')->on('items');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Capsule::schema()->drop('customers');
		Capsule::schema()->drop('items');
		Capsule::schema()->drop('orders');
		Capsule::schema()->drop('item_order');
	}

}