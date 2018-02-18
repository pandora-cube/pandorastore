<?php
require_once("models/user.php");

$userID = $_POST["UserID"];
$password = $_POST["Password"];

$user_model = new User($userID, $password, true);
$user_data = $user_model->getData();

$user_compel_model = new User($userID, null, null, true);
$user_compel_data = $user_compel_model->getData();

$logger = new Logger();
    
session_start();
if (is_null($user_data)) { // 로그인 실패 시
    if (is_null($user_compel_data))
        $logger->logSignIn(null, false);
    else
        $logger->logSignIn($user_compel_data["UserNumber"], false);

    $_SESSION["signin_try"]++;
    header("Location: /accounts/signin");
    return;
} else if ($user_data["Authenticated"] == 0) { // 인증된 계정이 아닌 경우
    header("Location: /accounts/signup_auth_input?email={$user_data["EMail"]}");
    return;
}

$logger->logSignIn($user_data["UserNumber"], true);

unset($_SESSION["signin_try"]);
$_SESSION["UserID"] = $user_data["EMail"];
$_SESSION["Password"] = $user_data["Password"];
header("Location: /");
?>
