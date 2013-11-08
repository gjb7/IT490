<?php
	class Customer extends IT490\Model {
		protected $fillable = array('first_name', 'last_name', 'address', 'city', 'state', 'zip');
		
		protected $rules = array(
			'first_name' => array('required'),
			'last_name' => array('required'),
			'address' => array('required'),
			'city' => array('required'),
			'state' => array('required'),
			'zip' => array('required', 'min:5'),
		);
		
		public function order() {
			return $this->hasMany('Order');
		}
		
		public function getNameAttribute() {
			return $this->first_name . ' ' . $this->last_name;
		}
	}
?>