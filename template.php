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
	public function loadVariable($name) {
		return $this->variables[$name];
	}

	public function loadView($view) {
		ob_start();
		require("views/$view.php");
		$string = ob_get_clean();
		$string = preg_replace("/\s\s+/", " ", $string);
		echo($string);
	}

	public function getLayout($name) {
		include("layouts/$name.php");
	}
}
?>
