<?php
require_once("libraries/functions/template.php");

$template = new Template("판도라스토어 회원 가입");
if (isset($_COOKIE["Error"])) {
    $error = json_decode($_COOKIE["Error"]);
    setcookie("Error", "", time()-3600, "/accounts/");
    $template->setAttribute("error_item", $error[0]);
    $template->setAttribute("error_data", $error[1]);
} else {
    $template->disableArea("error-script");
}
$template->disableArea("topOrbit");
$template->loadView("accounts/signup");
?>
