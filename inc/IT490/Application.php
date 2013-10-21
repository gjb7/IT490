<?php
	namespace IT490;
	
	class Application {
		// Singleton instance of the Application class.
		private static $instance = null;
		
		// Instance of Slim.
		private $slim = null;
		
		// Instance of Router.
		private $router = null;
		
		/**
		 * The root directory of the application. Usually set in your index.php file.
		 */
		public $root;
		
		/**
		 * Returns the singleton of the Application.
		 */
		public static function app() {
			if (!static::$instance) {
				static::$instance = new self();
			}
			return static::$instance;
		}
		
		// Private constructor. See Application::app instead.
		private function __construct() {
			$this->slim = new \Slim\Slim();
		}
		
		/**
		 * Allows for configuration based off the mode of the application.
		 */
		public function configure($mode, $callback = null) {
			if (is_callable($mode) && $callback == null) {
				$mode($this->slim);
			}
			else {
				$slim = $this->slim;
				
				$this->slim->configureMode($mode, function() use ($slim, $callback) {
					$callback($slim);
				});
			}
		}
		
		/**
		 * Start up the application.
		 *
		 * Does all the loading and setup for the application to be run.
		 */
		public function boot() {
			$this->router = new Router($this->slim);
			$this->router->loadRoutes();
			
			require_once path('app') . '/config.php';
		}
		
		/**
		 * Actually runs the application.
		 */
		public function run() {
			$this->router->serve();
		}
		
		// ------
		
		/**
		 * Returns the instance of the Router for this application.
		 */
		public function router() {
			return $this->router;
		}
	}
?>