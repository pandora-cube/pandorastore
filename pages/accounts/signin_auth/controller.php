<?php
require_once("models/user.php");

$userID = $_POST["UserID"];
$password = $_POST["Password"];

$user_model = new User($userID, $password, true);
$user_data = $user_model->getData();
    
session_start();
if (is_null($user_data)) { // 로그인 실패 시
    $_SESSION["signin_try"]++;
    header("Location: /accounts/signin");
    return;
} else if ($user_data["Authenticated"] == 0) { // 인증된 계정이 아닌 경우
    header("Location: /accounts/signup_auth_input?email={$user_data["EMail"]}");
    return;
}

unset($_SESSION["signin_try"]);
$_SESSION["UserID"] = $user_data["EMail"];
$_SESSION["Password"] = $user_data["Password"];
header("Location: /");
?>
