<?php
	app()->configure(function($app) {
		$app->config('templates.path', path('app') . '/views');
		
		\Slim\Extras\Views\Twig::$twigDirectory = 'vendor/twig/twig/lib';
		\Slim\Extras\Views\Twig::$twigExtensions[] = new \IT490\TwigExtension();
		$app->view(new \Slim\Extras\Views\Twig());
	});
	
	app()->configure('development', function($app) {
		$app->config('debug', true);
	});
?>