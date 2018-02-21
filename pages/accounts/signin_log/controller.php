<?php
require_once("libraries/functions/template.php");
require_once("models/log.php");

$log_model = new Log();
$log_data = $log_model->loadSignIn();

$template = new Template();
$template->setAttribute("log_data", $log_data);
$template->disableArea("topOrbit");
$template->loadView("accounts/signin_log");
?>
