<?php
	function path($path) {
		switch ($path) {
			case 'app':
				return IT490\Application::app()->root;
				break;
			default:
				return '';
				break;
		}
	}
?>