<?php
	namespace IT490\Renderer;
	
	use IT490\Router;
	
	class HTMLRenderer {
		private $slim = null;
		
		public function __construct($slim) {
			$this->slim = $slim;
		}
		
		public function render($output, $args = array()) {
			if (is_string($output)) {
				echo $output;
			}
			else {
				if ($output == null) {
					$output = array();
				}
				
				list($class, $method) = $args[0];
				
				$controllerName = str_replace('controller', '', strtolower($class));
				$templatePath = $controllerName . '/' . $method . '.twig';
				
				// We're making the assumption that, if the headers have been sent, then, most likely,
				// a redirect is taking place. We don't want to output anything, then.
				if (!headers_sent()) {
					$this->slim->render($templatePath, $output);
				}
			}
		}
	}
?>