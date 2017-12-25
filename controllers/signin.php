<?php
require("template.php");

$template = new Template();
$template->disableArea("topOrbit");
$template->loadView("signin");
?>
