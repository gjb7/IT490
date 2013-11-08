<?php
	namespace IT490;
	
	class Router {
		private $slim = null;
		
		private $rendererManager = null;
		
		/**
		 * Designated constructor.
		 *
		 * @param $slim Instance of Slim to use.
		 */
		public function __construct($slim) {
			$this->slim = $slim;
			$this->rendererManager = new RendererManager($this->slim);
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
			$this->get($path, $controller . '@index');
			$this->get($path . '/new',  $controller . '@create');
			$this->post($path, $controller . '@store');
			$this->get($path . '/:id', $controller . '@show');
			$this->get($path . '/:id/edit', $controller . '@edit');
			$this->put($path . '/:id', $controller . '@update');
			$this->delete($path . '/:id', $controller . '@destroy');
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
			return $this->route('GET', $path, $action);
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
			return $this->route('POST', $path, $action);
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
			return $this->route('PUT', $path, $action);
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
			return $this->route('DELETE', $path, $action);
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
			
			$route = $this->slim->{$method}($path, function() use ($action, $self) {
				$result = $self->perform($action, func_get_args());
				$self->render($result, $action);
			});
			
			if (is_string($action)) {
				$route->name($action);
			}
			
			return $route;
		}
		
		/**
		 * Performs an action for a route.
		 *
		 * @param $action The action to be performed. Can be a function or an array.
		 * @param $args Any arguments to be passed to the action.
		 */
		private function perform($action, $args) {
			if (is_string($action)) {
				return $this->performAction($action, $args);
			}
			else if (is_callable($action)) {
				return $this->performCallback($action, $args);
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
		private function performAction($action, $args) {
			list($class, $method) = self::controllerFromAction($action);
			$instance = new $class();
			return call_user_func_array(array($instance, $method), $args);
		}
		
		/**
		 * Performs a callback function action.
		 *
		 * @param $callback The callback function to be executed.
		 * @param $args The arguments to be passed to the function.
		 */
		private function performCallback($callback, $args) {
			return call_user_func_array($callback, $args);
		}
		
		private function render($result, $action) {
			if (is_string($action)) {
				$action = self::controllerFromAction($action);
			}
			
			$currentRoute = $this->slim->router()->getCurrentRoute();
			$pattern = $currentRoute->getPattern();
			$extension = pathinfo($pattern, PATHINFO_EXTENSION);
			
			$this->rendererManager->render($result, $extension, array($action));
		}
		
		/**
		 * Takes in an action and returns a controller class and a method.
		 */
		public static function controllerFromAction($action) {
			return explode('@', $action);
		}
	}
?>