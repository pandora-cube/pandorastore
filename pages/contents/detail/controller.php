<?php
require_once("libraries/functions/template.php");

$user = new User();
$user_data = $user->getData();

$template = new Template();
if ($user_data["PCubeMember"] != 1)
    $template->disableArea("review-write");
$template->loadView("contents/detail");
?>
