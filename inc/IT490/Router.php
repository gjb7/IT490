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
		
		public function controller($path, $controller) {
			$this->get($path, array($controller, 'index'));
			$this->get($path . '/new', array($controller, 'new'));
			$this->post($path, array($controller, 'create'));
			$this->get($path . '/:id', array($controller, 'show'));
			$this->get($path . '/:id/edit', array($controller, 'edit'));
			$this->put($path . '/:id', array($controller, 'update'));
			$this->delete($path . '/:id', array($controller, 'delete'));
		}
		
		public function get($path, $action) {
			$this->route('GET', $path, $action);
		}
		
		public function post($path, $action) {
			$this->route('POST', $path, $action);
		}
		
		public function put($path, $action) {
			$this->route('PUT', $path, $action);
		}
		
		public function delete($path, $action) {
			$this->route('DELETE', $path, $action);
		}
		
		public function route($method, $path, $action) {
			$method = strtolower($method);
			$self = $this;
			
			$this->slim->{$method}($path, function() use ($action, $self) {
				$self->performAction($action, func_get_args());
			});
		}
		
		private function performAction($action, $args) {
			if (is_array($action)) {
				$this->performController($action, $args);
			}
			else if (is_callable($action)) {
				$this->performCallback($action, $args);
			}
		}
		
		private function performController($controller, $args) {
			$class = $controller[0];
			$method = $controller[1];
			$instance = new $class();
			call_user_func_array(array($instance, $method), $args);
		}
		
		private function performCallback($callback, $args) {
			call_user_func_array($callback, $args);
		}
	}
?>