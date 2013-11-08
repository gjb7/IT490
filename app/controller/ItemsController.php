<?php
	use IT490\Exception\ValidatorException;
	
	class ItemsController {
		public function index() {
			return Item::all();
		}
		
		public function create() {
			
		}
		
		public function store() {
			$item = new Item($_POST['item']);
			
			try {
				$item->save();
			}
			catch (ValidatorException $e) {
				flash_errors($e->getErrors()->all());
				
				redirect_to_action('ItemsController@create');
				
				return;
			}
			
			redirect_to_action('ItemsController@show', array('id' => $item->id));
		}
		
		public function show($id) {
			return Item::find($id);
		}
		
		public function edit($id) {
			return Item::find($id);
		}
		
		public function update($id) {
			$item = Item::find($id);
			$item->fill($_POST['item']);
			
			try {
				$item->save();
			}
			catch (ValidatorException $e) {
				flash_errors($e->getErrors()->all());
				
				redirect_to_action('ItemsController@edit');
				
				return;
			}
			
			redirect_to_action('ItemsController@show', array('id' => $item->id));
		}
		
		public function destroy($id) {
			$item = Item::find($id);
			$item->delete();
		}
	}
?>