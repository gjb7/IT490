<?php
	namespace IT490;
	
	use IT490\FileExtensionHandler\HTMLFileExtensionHandler;
	use IT490\FileExtensionHandler\JSONFileExtensionHandler;
	
	class Renderer {
		private $handlers = array();
		private $defaultHandler = null;
		private $slim = null;
		
		public function __construct($slim) {
			$this->slim = $slim;
			
			$htmlRenderer = new HTMLFileExtensionHandler($this->slim);
			$this->registerHandler($htmlRenderer);
			$this->setDefaultHandler($htmlRenderer);
			
			$this->registerHandler(new JSONFileExtensionHandler);
		}
		
		public function registerHandler($handler) {
			$extension = str_replace('fileextensionhandler', '', strtolower(class_basename(get_class($handler))));
			
			$this->handlers[$extension] = $handler;
		}
		
		public function getDefaultHandler() {
			return $this->defaultHandler;
		}
		
		public function setDefaultHandler($defaultHandler) {
			$this->defaultHandler = $defaultHandler;
		}
		
		public function render($output, $extension = '', $args = array()) {
			$handler = $this->getDefaultHandler();
			
			if (isset($this->handlers[$extension])) {
				$handler = $this->handlers[$extension];
			}
			
			if (!$handler) {
				throw new Exception\HandlerNotFoundException();
			}
			
			$handler->render($output, $args);
		}
	}
?>