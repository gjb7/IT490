<?php
	class Item extends Illuminate\Database\Eloquent\Model {
		public function orders() {
			return $this->belongsToMany('Order');
		}
	}
?>