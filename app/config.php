<?php
	IT490\Application::app()->configure(function($app) {
		$app->config('templates.path', path('app') . '/views');
	});
	
	IT490\Application::app()->configure('development', function($app) {
		$app->config('debug', true);
	});
?>