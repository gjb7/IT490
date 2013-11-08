<?php
	class Item extends IT490\Model {
		protected $fillable = array('name', 'quantity', 'price');
		
		protected $rules = array(
			'name' => array('required'),
			'quantity' => array('required'),
			'price' => array('required'),
		);
		
		public function orders() {
			return $this->belongsToMany('Order')->withPivot('quantity');
		}
	}
?>