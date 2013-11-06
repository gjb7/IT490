<?php
	namespace IT490\FileExtensionHandler;
	
	class JSONFileExtensionHandler {
		public function render($output, $args = array()) {
			if (is_array($output)) {
				echo json_encode($output);
			}
			
		}
	}
?>