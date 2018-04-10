<?php
require_once("libraries/functions/template.php");

session_start();

$template = new Template("판도라스토어 회원 가입");
if ($_SESSION["signup_auth_try"] > 3) { // 3회 이상 실패 시
    $template->disableArea("auth-reinput");
    $template->disableArea("auth-input");
    $template->disableArea("email-error");
} else {
    $template->disableArea("auth-ban");
    if (isset($_GET["reinput"])) { // 재시도 시
        $template->setAttribute("count", $_SESSION["signup_auth_try"]);
    } else {
        $template->disableArea("auth-reinput");
    }
    if (isset($_GET["email"])) { // 이메일 전달 유무
        $template->setAttribute("email", $_GET["email"]);
        $template->disableArea("email-error");
    } else {
        $template->disableArea("auth-input");
    }
}
$template->disableArea("topOrbit");
$template->loadView("accounts/signup_auth_input");
?>
