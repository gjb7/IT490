<?php
	namespace IT490;
	
	class URLGenerator {
		private $slim = null;
		
		/**
		 * Designated constructor.
		 *
		 * You shouldn't have to create an instance of this. An instance is created whenever you create a new Application.
		 *
		 * @param $slim An instance of Slim.
		 */
		public function __construct($slim) {
			$this->slim = $slim;
		}
		
		/**
		 * Generates a URL from an action. Pretty much the same as URLGenerator->route.
		 *
		 * @param $action The name of the action. These are in the form of Controller@action.
		 * @param $parameters Any parameters to be substituted into the route's URL.
		 */
		public function action($action, $parameters = array()) {
			return $this->route($action, $parameters);
		}
		
		/**
		 * Generates a URL for an asset. Pretty much the same as URLGenerator->to.
		 *
		 * @param $path The path to generate the URL from.
		 */
		public function asset($path) {
			return $this->to($path);
		}
		
		/**
		 * Generates a URL from a route.
		 *
		 * @param $name The name of the route. These are in the form of Controller@action.
		 * @param $parameters Any parameters to be substituted into the route's URL.
		 */
		public function route($name, $parameters = array()) {
			return $this->slim->urlFor($name, $parameters);
		}
		
		/**
		 * Generates a URL from a path.
		 *
		 * @param $path The path to generate the URL from.
		 */
		public function to($path) {
			$rootUri = $this->slim->request()->getRootUri();
			
			if (!empty($rootUri) && !starts_with($path, $rootUri)) {
				$path = $rootUri . $path;
			}
			
			return $path;
		}
	}
?>