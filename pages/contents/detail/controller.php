<?php
require_once("libraries/functions/template.php");

$user = new User();
$user_data = $user->getData();
print($user_data["PCubeMember"] != 1);

$template = new Template();
if ($user_data["PCubeMember"] != 1)
    $template->disableArea("review-write");
$template->loadView("contents/detail");
?>
