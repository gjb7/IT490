<?php
	namespace IT490;
	
	use IT490\Exception\ValidatorException;
	
	class Model extends \Illuminate\Database\Eloquent\Model {
		/**
		 * The rules for validation for this model.
		 */
		protected $rules = array();
		
		/**
		 * Sets up an event when a model is saved to perform validation on the model.
		 */
		public static function boot() {
			parent::boot();
			
			self::saving(function($model) {
				if (count($model->rules) > 0) {
					$validator = new Validator($model->attributesToArray(), $model->rules);
					
					if ($validator->fails()) {
						throw new ValidatorException($validator);
						
						return false;
					}
				}
				
				return true;
			});
		}
	}
?>