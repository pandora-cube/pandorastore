<?php
require_once("libraries/functions/template.php");

$search = $_GET["search"];

$template = new Template("판도라큐브 일정");
$template->disableArea("topOrbit");
$template->loadView("pandora/calendar");
?>
