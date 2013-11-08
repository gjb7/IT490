<?php
	namespace IT490;
	
	// \Illuminate\Validation\Validator subclass to do validation without requiring Illuminates translation module.
	class Validator extends \Illuminate\Validation\Validator {
		// Array of messages where the key is the rule, and the value is the message.
		protected $customMessages = array(
			'required' => '%s is required.',
		);
		
		/**
		 * Designated constructor.
		 *
		 * @param $data The data to validate.
		 * @param $rules The rules to validate the data against.
		 */
		public function __construct($data, $rules) {
			$this->data = $this->parseData($data);
			$this->rules = $this->explodeRules($rules);
		}
		
		/**
		 * Get the validation message for an attribute and rule.
		 *
		 * @param $attribute The attribute/key from the data array
		 * @param $rule The rule that you need to get an attribute for.
		 */
		protected function getMessage($attribute, $rule) {
			$lowerRule = strtolower($rule);
			
			$message = sprintf($this->customMessages[$lowerRule], $this->getAttribute($attribute));
			return ucfirst($message);
		}
		
		/**
		 * Get the proper error message for an attribute and size rule.
		 *
		 * @param $attribute The attribute/key from the data array
		 * @param $rule The rule that you need to get an attribute for.
		 */
		protected function getSizeMessage($attribute, $rule) {
			return $attribute . ' ' . $rule;
		}
		
		/**
		 * Get the displayable name of the attribute.
		 *
		 * @param $attribute The attribute/key from the data array to make human readable.
		 */
		protected function getAttribute($attribute) {
			return str_replace('_', ' ', $attribute);
		}
	}
?>