<?php
	class Customer extends Illuminate\Database\Eloquent\Model {
		protected $fillable = array('first_name', 'last_name', 'address', 'city', 'state', 'zip');
		
		public function order() {
			return $this->hasMany('Order');
		}
	}
?>