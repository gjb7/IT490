<?php
	namespace IT490;
	
	class Router {
		private $slim = null;
		
		public function __construct($slim) {
			$this->slim = $slim;
		}
		
		public function loadRoutes() {
			require_once path('app') . '/routes.php';
		}
		
		public function serve() {
			$this->slim->run();
		}
	}
?>