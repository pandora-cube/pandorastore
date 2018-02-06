<?php
require_once("libraries/functions/template.php");

$template = new Template();
$template->disableArea("topOrbit");
$template->loadView("accounts/signin");
?>
