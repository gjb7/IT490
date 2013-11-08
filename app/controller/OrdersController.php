<?php
	class OrdersController {
		public function index() {
			return Order::all();
		}
		
		public function create() {
			return array(
				'customers' => Customer::all(),
				'items' => Item::all()
			);
		}
		
		public function store() {
			$order = new Order;
			$customer = Customer::find($_POST['order']['customer_id']);
			
			if (!$customer) {
				flash('error', 'Customer not found.');
				
				redirect_to_action('OrdersController@create');
				
				return;
			}
			
			$order->customer()->associate($customer);
			
			$total = 0;
			$items = array();
			
			for ($i = 0; $i < count($_POST['order']['items']['id']); $i++) {
				$itemID = $_POST['order']['items']['id'][$i];
				
				if (!isset($_POST['order']['items']['quantity'][$i])) {
					flash('error', 'Mismatch of number of item ids to number of item quantities.');
					
					redirect_to_action('OrdersController@create');
					
					return;
				}
				
				$quantity = $_POST['order']['items']['quantity'][$i];
				
				$item = Item::find($itemID);
				
				if (!$item) {
					flash('error', 'Item not found');
					
					redirect_to_action('OrdersController@create');
					
					return;
				}
				
				$item->quantity -= $quantity;
				$items[] = $item;
				$total = $item->price * $quantity;
			}
			
			$order->amount_due = $total;
			
			try {
				$order->save();
			}
			catch (ValidatorException $e) {
				flash_errors($e->getErrors()->all());
				
				redirect_to_action('OrdersController@create');
				
				return;
			}
			
			foreach ($items as $item) {
				$order->items()->save($item);
			}
			
			redirect_to_action('OrdersController@show', array('id' => $order->id));
		}
		
		public function show($id) {
			return Order::with('customer', 'items')->find($id);
		}
	}
?>