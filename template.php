<?php
class Template {
    public $title;
    private $attributes;
    private $disabled;

    public function __construct($title = "Pandora Store") {
        $this->title = $title;
    }

    public function setAttribute($key, $value) {
        $this->attributes[$key] = $value;
    }
    public function getAttribute($key) {
        if(!isset($this->attributes[$key]))
            return "";
        return $this->attributes[$key];
    }

    public function disableArea($area) {
        $this->disabled[$area] = true;
    }
    public function isEnabledArea($area) {
        return $this->disabled[$area] !== true;
    }

    public function loadLayout($layout) {
        include("layouts/$layout.php");
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
