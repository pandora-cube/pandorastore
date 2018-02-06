<?php
/*
 *      [Framework for Managing Design and Data on Websites]
 * 
 *          Fadow (파도)
 *          v1.02
 * 
 *      First Release:  2017.06.18
 *      Last Update:    2018.01.29
 * 
 *      Coded by Seongbum @ All rights reserved.
 *          sBum.Seo@gmail.com
 *          http://seongbum.com
 * 
 */

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
        if (!isset($this->attributes[$key]))
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
        if (is_file("layouts/$layout/controller.php"))
            require("layouts/$layout/controller.php");
        include("layouts/$layout/view.php");
    }

    public function loadView($view, $print = true) {
        ob_start();
        require("pages/$view/view.php");
        $string = ob_get_clean();
        $string = preg_replace("/\s\s+/", " ", $string);

        if ($print === true)
            print($string);
        return $string;
    }
}
?>
