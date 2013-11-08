<?php
	namespace IT490;
	
	// All you need to know about this class is that it allows certain functions that are implemented
	// by Illuminate to be used by our templating engine, Twig.
	class TwigExtension extends \Twig_Extension {
		public function getFunctions() {
			return array(
				new \Twig_SimpleFunction('action', 'action'),
				new \Twig_SimpleFunction('asset', 'asset'),
				new \Twig_SimpleFunction('link_to', 'link_to', array('is_safe' => array('html'))),
				new \Twig_SimpleFunction('link_to_asset', 'link_to_asset', array('is_safe' => array('html'))),
				new \Twig_SimpleFunction('link_to_route', 'link_to_route', array('is_safe' => array('html'))),
				new \Twig_SimpleFunction('link_to_action', 'link_to_action', array('is_safe' => array('html'))),
				new \Twig_SimpleFunction('route', 'route'),
				new \Twig_SimpleFunction('secure_asset', 'secure_asset'),
				new \Twig_SimpleFunction('secure_url', 'secure_url'),
				new \Twig_SimpleFunction('url', 'url'),
			);
		}
		
		public function getFilters() {
			return array(
 				new \Twig_SimpleFilter('plural', 'str_plural'),
			);
		}
		
		public function getName() {
			return 'it490';
		}
	}
	
?>