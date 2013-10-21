<?php
	namespace IT490;
	
	
	
	class Application {
		private $slim = null;
		private $router = null;
		
		private $config = array();
		
		public function __construct() {
			$this->slim = new \Slim\Slim();
		}
		
		public function configure($mode, $callback) {
			$this->config[$mode] = $callback;
		}
		
		public function boot() {
			$this->router = new Router($this->slim);
			$this->router->loadRoutes();
		}
		
		// ------
		
		public function router() {
			return $this->router;
		}
	}
?>