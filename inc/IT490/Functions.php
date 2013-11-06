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
	
?>