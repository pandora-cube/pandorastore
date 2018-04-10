<?php
require_once("libraries/functions/template.php");

$template = new Template("판도라스토어 회원 탈퇴");
$template->disableArea("topOrbit");
$template->loadView("accounts/leave");
?>
