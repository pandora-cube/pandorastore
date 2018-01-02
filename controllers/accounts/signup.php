<?php
require_once("template.php");

$template = new Template();
$template->disableArea("topOrbit");
$template->loadView("accounts/signup");
?>
