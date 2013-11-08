<?php
	namespace IT490;
	
	// Abstract class for creating a renderer. That is, creating a way to take in data and serialize it for
	// the body of an HTTP response.
	abstract class Renderer {
		/**
		 * Renders based off of some data. Subclasses are required to implement this method to perform the work necessary
		 * to take some data, and transform it into a serialized result.
		 *
		 * For example, the HTMLRenderer will take in the data and output a template. The JSONRenderer will take in the data
		 * and serialize it as a JSON object.
		 */
		abstract public function render($data, $args = array());
	}
?>