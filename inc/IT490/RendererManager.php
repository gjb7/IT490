<?php
	namespace IT490;
	
	use IT490\Renderer\HTMLRenderer;
	use IT490\Renderer\JSONRenderer;
	
	use Illuminate\Database\Eloquent\Collection;
	use Illuminate\Database\Eloquent\Model;
	
	use Illuminate\Support\Pluralizer;
	
	class RendererManager {
		private $renderers = array();
		private $defaultRenderer = null;
		private $slim = null;
		
		public function __construct($slim) {
			$this->slim = $slim;
			
			$htmlRenderer = new HTMLRenderer($this->slim);
			$this->registerRenderer($htmlRenderer);
			$this->setDefaultRenderer($htmlRenderer);
			
			$this->registerRenderer(new JSONRenderer);
		}
		
		public function registerRenderer($renderer) {
			$extension = str_replace('renderer', '', strtolower(class_basename(get_class($renderer))));
			
			$this->renderers[$extension] = $renderer;
		}
		
		public function getDefaultRenderer() {
			return $this->defaultRenderer;
		}
		
		public function setDefaultRenderer($defaultRenderer) {
			$this->defaultRenderer = $defaultRenderer;
		}
		
		public function render($output, $extension = '', $args = array()) {
			$renderer = $this->getDefaultRenderer();
			
			if (isset($this->renderers[$extension])) {
				$renderer = $this->renderers[$extension];
			}
			
			if (!$renderer) {
				throw new Exception\RendererNotFoundException();
			}
			
			if ($output instanceof Collection) {
				if (!$output->isEmpty()) {
					$key = self::keyFromClassName(get_class($output[0]));
					$output = array($key => $output);
				}
				else {
					$output = $output->toArray();
				}
				
/* 				$output = $output->toArray(); */
			}
			else if ($output instanceof Model) {
				$key = self::keyFromClassName(get_class($output));
				$output = array($key => $output);
			}
			
			$renderer->render($output, $args);
		}
		
		private static function keyFromClassName($className) {
			return Pluralizer::plural(strtolower($className));
		}
	}
?>