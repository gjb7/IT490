<?php
	class Order extends IT490\Model {
		protected $rules = array(
			'amount_due' => 'required'
		);
		
		public function customer() {
			return $this->belongsTo('Customer');
		}
		
		public function items() {
			return $this->belongsToMany('Item')->withPivot('quantity');
		}
	}
?>