<?php
require_once("../models/users.php");

$userID = $_POST["UserID"];

$data = array();

if (strlen($userID) < 1) {
    $data = [-1, "어서 작성해 주세요."];
} else if (strlen($userID) > 320) {
    $data = [0, "너무 깁니다."];
} else if (strpos($userID, "@") === false) {
    $data = [-1, "도메인까지 작성해 주세요~"];
} else {
    $config_db = parse_ini_file("../configs/database.ini");
    $mysqli = mysqli_connect($config_db["host"], $config_db["user"], $config_db["password"], $config_db["database"]); {
        $users_model = new Users($mysqli, $config_db["table"]);
        $users_data = $users_model->load([["UserID", "=", $userID]]);
    } $mysqli->close();

    if (!is_null($users_data)) {
        $data = [0, "해당 이메일로 가입된 계정이 존재합니다."];
    } else {
        $data = [1, "좋습니다."];
    }
}

print(json_encode($data));
?>
