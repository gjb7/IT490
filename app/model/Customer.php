<?php
	class Customer extends Illuminate\Database\Eloquent\Model {
		public function order() {
			return $this->hasMany('Order');
		}
	}
?>