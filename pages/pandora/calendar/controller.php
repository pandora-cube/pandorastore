<?php
require_once("template.php");

$search = $_GET["search"];

$template = new Template();
$template->disableArea("topOrbit");
$template->loadView("pandora/calendar");
?>
