<?php
require_once("models/log.php");

$user_model = new User();
$user_data = $user_model->getData();

if (isset($user_data)) {
    $log_model = new Log();
    $log_data = $log_model->load("log_signin", [["UserNumber", "=", $user_data["UserNumber"]]]);
}
?>
