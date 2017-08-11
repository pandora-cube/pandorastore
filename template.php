<?php
class Template {
	public $title;
	private $variables;

	public function __construct($title = "Pandora Store") {
		$this->title = $title;
	}

	public function setVariable($name, $value) {
		$this->variables[$name] = $value;
	}
	public function getVariable($name) {
		return $this->variables[$name];
	}

	public function loadLayout($name) {
		include("layouts/$name.php");
	}

	public function loadView($view) {
		ob_start();
		require("views/$view.php");
		$string = ob_get_clean();
		$string = preg_replace("/\s\s+/", " ", $string);
		echo($string);
	}
}
?>
