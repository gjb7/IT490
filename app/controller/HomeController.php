<?php
	class HomeController {
		public function home() {
			$result = array('count' => array());
			
			$result['count']['customers'] = Customer::all()->count();
			$result['count']['items'] = Item::all()->count();
			$result['count']['orders'] = Order::all()->count();
			
			return $result;
		}
	}
?>