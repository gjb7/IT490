<?php
	class 17102013_124445_create_tables {
		public function up() {
			Capsule::schema()->create('customers', function($table) {
				$table->increments('id');
				$table->string('first_name');
				$table->string('last_name');
				$table->string('street');
				$table->string('city');
				$table->string('state');
				$table->integer('zip_code');
				$table->timestamps();
			});
			
			Capsule::schema()->create('items', function($table) {
				$table->increments('id');
				$table->string('name')->unique();
				$table->integer('quantity');
				$table->float('price');
			});
			
			Capsule::schema()->create('orders', function($table) {
				$table->increments('id');
				$table->foreign('customer_id')->references('id')->on('customers')->onDelete('cascade');
				$table->float('amount_due');
			});
			
			Capsule::schema()->create('item_order', function($table) {
				$table->integer('order_id');
				$table->integer('item_id');
			});
		}
		
		public function down() {
			Capsule::schema()->drop('customers');
			Capsule::schema()->drop('items');
			Capsule::schema()->drop('orders');
			Capsule::schema()->drop('item_order');
		}
	}
?>