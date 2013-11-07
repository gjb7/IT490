<?php
	class CustomersController {
		public function index() {
			return Customer::all();
		}
		
		public function create() {
			
		}
		
		public function store() {
			$customer = new Customer($_POST['customer']);
			$customer->save();
			
			redirect_to_action('CustomersController@show', array('id' => $customer->id));
		}
		
		public function show($id) {
			return Customer::find($id);
		}
		
		public function edit($id) {
			return Customer::find($id);
		}
		
		public function update($id) {
			$customer = Customer::find($id);
			$customer->fill($_POST['customer']);
			$customer->save();
		}
		
		public function destroy($id) {
			$customer = Customer::find($id);
			$customer->delete();
		}
	}
?>