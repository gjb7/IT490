<?php
	namespace IT490;
	
	class URLGenerator {
		private $slim = null;
		
		public function __construct($slim) {
			$this->slim = $slim;
		}
		
		// HomeController@index
		public function action($action, $parameters = array(), $absolute = true) {
			return $this->route($action, $parameters);
		}
		
		public function asset($path, $secure = null) {
			return $this->to($path);
		}
		
		public function route($name, $parameters = array(), $route = null) {
			return $this->slim->urlFor($name, $parameters);
		}
		
		public function to($path, $extra = array(), $secure = null) {
			return $this->slim->request()->getRootUri() . $path;
		}
	}
?>