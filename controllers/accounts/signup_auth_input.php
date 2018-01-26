<?php
require_once("template.php");

$template = new Template();
if (isset($_GET["email"])) {
    $template->setAttribute("email", $_GET["email"]);
    $template->disableArea("auth-error");
} else {
    $template->disableArea("auth-input");
}
if (is_null($_GET["reinput"])) {
    $template->disableArea("auth-reinput");
}
$template->disableArea("topOrbit");
$template->loadView("accounts/signup_auth_input");
?>
