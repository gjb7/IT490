<?php
	namespace IT490;
	
	class HTMLBuilder {
		private $url;
		
		/**
		 * Designated constructor.
		 *
		 * You shouldn't have to create this. It's created by default when creating a new Application.
		 *
		 * @param $url An instance of URLGenerator.
		 */
		public function __construct($url) {
			$this->url = $url;
		}
		
		/**
		 * Returns an HTML link.
		 *
		 * @param $url The url of the link.
		 * @param $title The title of the link.
		 * @param $attributes Any HTML attributes for the link.
		 */
		public function link($url, $title = null, $attributes = array()) {
			$url = $this->url->to($url, array());
			
			if (is_null($title) or $title === false) {
				$title = $url;
			}
			
			return '<a href="' . $url . '"' . $this->attributes($attributes) . '>' . e($title) . '</a>';
		}
		
		/**
		 * Returns a link to an asset. Pretty much the same as HTMLBuilder->link.
		 */
		public function linkAsset($url, $title = null, $attributes = array()) {
			return $this->link($this->url->asset($url), $title, $attributes);
		}
		
		/**
		 * Returns a link to a route.
		 *
		 * @param $name The name of the route. These are in the form of Controller@action.
		 * @param $title The title of the link.
		 * @param $parameters Any parameters to be substituted into the route's URL.
		 * @param $attributes Any HTML attributes for the link.
		 */
		public function linkRoute($name, $title = null, $parameters = array(), $attributes = array()) {
			return $this->link($this->url->route($name, $parameters), $title, $attributes);
		}
		
		/**
		 * Returns a link to an action. Pretty much the same as HTMLBuilder->linkRoute.
		 */
		public function linkAction($action, $title = null, $parameters = array(), $attributes = array()) {
			return $this->link($this->url->action($action, $parameters), $title, $attributes);
		}
		
		/**
		 * Takes in an array of attributes, and renders them as HTML attributes.
		 */
		public function attributes($attributes) {
			$htmlAttributes = array();
			
			foreach ($attributes as $key => $value) {
				$htmlAttributes[] = $key . '="' . e($value) . '"';
			}
			
			if (count($htmlAttributes) > 0) {
				return ' ' . implode(' ', $htmlAttributes);
			}
			
			return '';
		}
	}
?>