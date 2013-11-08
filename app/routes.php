<?php
	$router = app()->router();
	
	$router->get('/', 'HomeController@home');
	$router->controller('/customers', 'CustomersController');
	$router->controller('/items', 'ItemsController');
	
	// We do this cause we don't want to worry about the other ones. Yeah, i guess we're lazy.
	// Meh, it's almost 3 AM and I'm still working on this the night before it's due. I really want to go to bed now.
	$router->get('/orders', 'OrdersController@index');
	$router->get('/orders/new', 'OrdersController@create');
	$router->post('/orders', 'OrdersController@store');
	$router->get('/orders/:id', 'OrdersController@show');
?>