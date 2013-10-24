<?php
	namespace IT490;
	
	class Router {
		private $slim = null;
		
		/**
		 * Designated constructor.
		 *
		 * @param $slim Instance of Slim to use.
		 */
		public function __construct($slim) {
			$this->slim = $slim;
		}
		
		/**
		 * Loads the routes for an application.
		 */
		public function loadRoutes() {
			require_once path('app') . '/routes.php';
		}
		
		/**
		 * Serves a response for the requst.
		 */
		public function serve() {
			$this->slim->run();
		}
		
		/**
		 * Maps a controller class to REST endpoints.
		 *
		 * @param $path The root path that all subpaths are based on.
		 * @param $controller The name of the controller class that will get run.
		 */
		public function controller($path, $controller) {
			$this->get($path, array($controller, 'index'));
			$this->get($path . '/new', array($controller, 'new'));
			$this->post($path, array($controller, 'create'));
			$this->get($path . '/:id', array($controller, 'show'));
			$this->get($path . '/:id/edit', array($controller, 'edit'));
			$this->put($path . '/:id', array($controller, 'update'));
			$this->delete($path . '/:id', array($controller, 'delete'));
		}
		
		/**
		 * Adds a route for a GET request.
		 *
		 * The action can either be an array (for an object), or a function to be executed.
		 *
		 * @param $path The path to trigger the action.
		 * @param $action The action to be performed.
		 */
		public function get($path, $action) {
			$this->route('GET', $path, $action);
		}
		
		/**
		 * Adds a route for a POST request.
		 *
		 * The action can either be an array (for an object), or a function to be executed.
		 *
		 * @param $path The path to trigger the action.
		 * @param $action The action to be performed.
		 */
		public function post($path, $action) {
			$this->route('POST', $path, $action);
		}
		
		/**
		 * Adds a route for a PUT request.
		 *
		 * The action can either be an array (for an object), or a function to be executed.
		 *
		 * @param $path The path to trigger the action.
		 * @param $action The action to be performed.
		 */
		public function put($path, $action) {
			$this->route('PUT', $path, $action);
		}
		
		/**
		 * Adds a route for a DELETE request.
		 *
		 * The action can either be an array (for an object), or a function to be executed.
		 *
		 * @param $path The path to trigger the action.
		 * @param $action The action to be performed.
		 */
		public function delete($path, $action) {
			$this->route('DELETE', $path, $action);
		}
		
		/**
		 * Adds a route for the given HTTP method.
		 *
		 * The action can either be an array (for an object), or a function to be executed.
		 *
		 * @param $method The HTTP method to handle.
		 * @param $path The path to trigger the action.
		 * @param $action The action to be performed.
		 */
		public function route($method, $path, $action) {
			$method = strtolower($method);
			$self = $this;
			
			$this->slim->{$method}($path, function() use ($action, $self) {
				$self->performAction($action, func_get_args());
			});
		}
		
		/**
		 * Performs an action for a route.
		 *
		 * @param $action The action to be performed. Can be a function or an array.
		 * @param $args Any arguments to be passed to the action.
		 */
		private function performAction($action, $args) {
			if (is_array($action)) {
				$this->performController($action, $args);
			}
			else if (is_callable($action)) {
				$this->performCallback($action, $args);
			}
		}
		
		/**
		 * Performs a controller action.
		 *
		 * This creates an instance of the given controller class and calls the specified method with a given arguments.
		 *
		 * @param $controller An array designating a class/method pair to be executed. See call_user_func_array for details.
		 * @param $args The arguments to be passed to the method.
		 */
		private function performController($controller, $args) {
			$class = $controller[0];
			$method = $controller[1];
			$instance = new $class();
			call_user_func_array(array($instance, $method), $args);
		}
		
		/**
		 * Performs a callback function action.
		 *
		 * @param $callback The callback function to be executed.
		 * @param $args The arguments to be passed to the function.
		 */
		private function performCallback($callback, $args) {
			call_user_func_array($callback, $args);
		}
	}
?>