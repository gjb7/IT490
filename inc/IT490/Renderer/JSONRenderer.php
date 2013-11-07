<?php
	namespace IT490\Renderer;
	
	class JSONRenderer {
		public function render($output, $args = array()) {
			if (is_array($output)) {
				echo json_encode($output);
			}
			
		}
	}
?>