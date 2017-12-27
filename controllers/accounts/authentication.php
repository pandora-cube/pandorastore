<?php
require("models/user.php");

$userID = $_POST["UserID"];
$password = $_POST["Password"];

$config_db = parse_ini_file("configs/database.ini");
$mysqli = mysqli_connect($config_db["host"], $config_db["user"], $config_db["password"], $config_db["database"]); {
    $user_model = new User($mysqli, $config_db["table"]);
    $user_data = $user_model->load($userID, $password, true);
} $mysqli->close();
    
session_start();
if (is_null($user_data)) { // 로그인 실패 시
    $_SESSION["signin_try"]++;
    header("Location: /accounts/signin");
    return;
}

unset($_SESSION["signin_try"]);
$_SESSION["UserID"] = $user_data["UserID"];
$_SESSION["Password"] = $user_data["Password"];
header("Location: /");
?>
