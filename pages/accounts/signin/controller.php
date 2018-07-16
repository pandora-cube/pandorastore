<?php
require_once("libraries/functions/template.php");

$template = new Template("판도라스토어 로그인");
$template->disableArea("topOrbit");
$template->loadView("accounts/signin");
?>
