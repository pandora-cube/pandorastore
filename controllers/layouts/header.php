<?php
require_once("models/user.php");

session_start();

loop:
if (isset($_SESSION["UserID"]) && isset($_SESSION["Password"])) { // 이미 로그인한 경우
    $config_db = parse_ini_file("configs/database.ini");
    $mysqli = mysqli_connect($config_db["host"], $config_db["user"], $config_db["password"], $config_db["database"]); {
        $user_model = new User($_SESSION["UserID"], $_SESSION["Password"], false);
        $user_data = $user_model->getData();
    } $mysqli->close();

    if (is_null($user_data)) { // 로그인 정보가 유효하지 않은 경우
        session_destroy();
        goto loop;
    }

    $this->disableArea("signin");
    $this->setAttribute("Nickname", $user_data["Nickname"]);
} else {
    $this->disableArea("user-button");
}
?>
