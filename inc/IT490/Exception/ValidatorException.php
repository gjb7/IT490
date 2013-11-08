<?php
	namespace IT490\Exception;
	
	use IT490\Validator;
	
	class ValidatorException extends \Exception {
		private $errors;
		
		public function __construct($container) {
		    $this->errors = ($container instanceof Validator) ? $container->errors() : $container;
		
		    parent::__construct(null);
		}
		
		public function getErrors() {
		    return $this->errors;
		}
	
	}
?>