<?php
	class Order extends Illuminate\Database\Eloquent\Model {
		public function customer() {
			return $this->belongsTo('Customer');
		}
		
		public function items() {
			return $this->belongsToMany('Item');
		}
	}
?>