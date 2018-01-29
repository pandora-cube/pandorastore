<?php
require_once("template.php");
require_once("models/user.php");

session_start();

$email = $_GET["email"];
$authcode = $_GET["authcode"];

if ($_SESSION["signup_auth_try"] > 3) { // 3회 이상 실패 시
    header("Location: /accounts/signup_auth_input?email={$email}&reinput=1"); // 인증코드 입력 페이지로 연결
    return;
}

$user = new User($email, null, null, true);
$user_data = $user->getData();

$template = new Template();
if ($user_data["Authenticated"] != 0) { // 이미 가입된 계정인 경우
    $template->setAttribute("email", $email);
    $template->disableArea("auth-complete");
} else if ($user_data["AuthCode"] === $authcode) { // 인증 성공 시
    $user->update(["Authenticated" => 1]);
    $template->setAttribute("nickname", $user_data["Nickname"]);
    $template->disableArea("already-authenticated");

    if ($user_data["PCubeMember"] != 2) { // 판도라큐브 회원 체크하지 않았을 시
        $template->disableArea("pcube-member-inform");
    }
} else { // 인증 실패 시
    if (is_null($_SESSION["signup_auth_try"])) {
        $_SESSION["signup_auth_try"] = 1;
    } else {
        $_SESSION["signup_auth_try"]++;
    }

    // 인증코드 입력 페이지로 연결
    header("Location: /accounts/signup_auth_input?email={$email}&reinput=1");
    return;
}
$template->disableArea("topOrbit");
$template->loadView("accounts/signup_auth_action");
?>
