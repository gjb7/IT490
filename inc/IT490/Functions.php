<?php
	// TODO: This can probably be removed in the future.
	function path($path) {
		switch ($path) {
			case 'app':
				return app()->root;
				break;
			default:
				return '';
				break;
		}
	}
	
	/**
	 * Redirects to a different action.
	 *
	 * @param $action The name of the action. These are in the form of Controller@action.
	 * @param $parameters Any parameters to be substituted into the route's URL.
	 */
	function redirect_to_action($action, $parameters = array()) {
		app()->slim()->redirect(app('url')->action($action, $parameters));
	}
	
	/**
	 * Flashes a message for the next request.
	 *
	 * @param $type A type/category for the message.
	 * @param $message The message to show.
	 */
	function flash($type, $message) {
		app()->slim()->flash($type, $message);
	}
	
	function flash_errors($errors) {
		flash('error', $errors);
	}
?>