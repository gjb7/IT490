<?php
	namespace IT490;
	
	class HTMLBuilder {
		private $url;
		
		public function __construct($url) {
			$this->url = $url;
		}
		
		public function link($url, $title = null, $attributes = array(), $secure = null) {
			$url = $this->url->to($url, array(), $secure);
			
			if (is_null($title) or $title === false) {
				$title = $url;
			}
			
			return '<a href="' . $url . '"' . $this->attributes($attributes) . '>' . e($title) . '</a>';
		}
		
		public function linkAsset($url, $title = null, $attributes = array(), $secure = null) {
			return $this->link($this->url->asset($url, $secure), $title, $attributes, $secure);
		}
		
		public function linkRoute($name, $title = null, $parameters = array(), $attributes = array()) {
			return $this->link($this->url->route($name, $parameters), $title, $attributes);
		}
		
		public function linkAction($action, $title = null, $parameters = array(), $attributes = array()) {
			return $this->link($this->url->action($action, $parameters), $title, $attributes);
		}
		
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