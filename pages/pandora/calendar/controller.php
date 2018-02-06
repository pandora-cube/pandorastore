<?php
require_once("libraries/functions/template.php");

$search = $_GET["search"];

$template = new Template();
$template->disableArea("topOrbit");
$template->loadView("pandora/calendar");
?>
