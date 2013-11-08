<?php
	namespace IT490;
	
	use IT490\Renderer\HTMLRenderer;
	use IT490\Renderer\JSONRenderer;
	use IT490\Model;
	
	use Illuminate\Database\Eloquent\Collection;
	
	use Illuminate\Support\Pluralizer;
	
	class RendererManager {
		private $renderers = array();
		private $defaultRenderer = null;
		private $slim = null;
		
		/**
		 * Designated Constructor. Registers a few built-in renderers.
		 *
		 * You shouldn't have to create an instance of a RendererManager yourself. If you create a Router, it will create one itself.
		 *
		 * @param $slim An instance of Slim.
		 */
		public function __construct($slim) {
			$this->slim = $slim;
			
			$htmlRenderer = new HTMLRenderer($this->slim);
			$this->registerRenderer($htmlRenderer);
			$this->setDefaultRenderer($htmlRenderer);
			
			$this->registerRenderer(new JSONRenderer);
		}
		
		/**
		 * Registers an instance of a Renderer subclass.
		 */
		public function registerRenderer($renderer) {
			$extension = str_replace('renderer', '', strtolower(class_basename(get_class($renderer))));
			
			$this->renderers[$extension] = $renderer;
		}
		
		/**
		 * Gets the default renderer that's used as a fallback.
		 */
		public function getDefaultRenderer() {
			return $this->defaultRenderer;
		}
		
		/**
		 * Sets the default renderer that's used as a fallback if no other renderer is found.
		 */
		public function setDefaultRenderer($defaultRenderer) {
			$this->defaultRenderer = $defaultRenderer;
		}
		
		/**
		 * Renders the body of our HTTP response based off of sone data.
		 *
		 * @param $data The data to be rendered.
		 * @param $extension A file extension. This determines what renderer is used.
		 * @param $args Any arguments that should be passed to a renderer.
		 */
		public function render($data, $extension = '', $args = array()) {
			$renderer = $this->getDefaultRenderer();
			
			if (isset($this->renderers[$extension])) {
				$renderer = $this->renderers[$extension];
			}
			
			if (!$renderer) {
				throw new Exception\RendererNotFoundException();
			}
			
			if ($data instanceof Collection) {
				if (!$data->isEmpty()) {
					$key = self::pluralKeyFromClassName(get_class($data[0]));
					$data = array($key => $data);
				}
				else {
					$data = $data->toArray();
				}
			}
			else if ($data instanceof Model) {
				$key = self::singularKeyFromClassName(get_class($data));
				$data = array($key => $data);
			}
			
			$renderer->render($data, $args);
		}
		
		/**
		 * Makes a pluralized key from a class name for use as a key in an array using Illuminate's Pluralizer class.
		 *
		 * @param $className The name of the class to turn into a key.
		 * @return The transformed key. 
		 */
		private static function pluralKeyFromClassName($className) {
			return Pluralizer::plural(strtolower($className));
		}
		
		/**
		 * Makes a singularlized key from a class name for use as a key in an array using Illuminate's Pluralizer class.
		 *
		 * @param $className The name of the class to turn into a key.
		 * @return The transformed key. 
		 */
		private static function singularKeyFromClassName($className) {
			return Pluralizer::singular(strtolower($className));
		}
	}
?>