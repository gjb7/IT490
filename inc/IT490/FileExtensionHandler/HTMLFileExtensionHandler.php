<?php
	namespace IT490\FileExtensionHandler;
	
	class HTMLFileExtensionHandler {
		private $slim = null;
		
		public function __construct($slim) {
			$this->slim = $slim;
		}
		
		public function render($output, $args = array()) {
			if (is_string($output)) {
				echo $output;
			} else if (count($args) >= 2) {
				if ($output == null) {
					$output = array();
				}
				
				$controllerName = str_replace('controller', '', strtolower($args[0]));
				$templatePath = $controllerName . '/' . $args[1] . '.twig';
				
				$this->slim->render($templatePath, $output);
			}
		}
	}
?>