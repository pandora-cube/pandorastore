<?php
require_once("models/users.php");

function checkAccount($key, $input, $config_db) {
    $data = [];
    $value = $input[$key];
    $valueCheck = $input["{$key}Check"];

    switch ($key) {
        case "Nickname": // 닉네임 검사
            if (strlen($value) < 1) {
                $data = [-1, ""];
            } else if (strlen($value) > 16) {
                $data = [0, "너무 깁니다."];
            } else {
                $mysqli = mysqli_connect($config_db["host"], $config_db["user"], $config_db["password"], $config_db["database"]); {
                    $users_model = new Users($mysqli, $config_db["table"]);
                    $users_data = $users_model->load([["Nickname", "=", $value], ["Authenticated", "=", 1]]);
                } $mysqli->close();

                if (isset($users_data)) {
                    $data = [0, "이미 사용중인 닉네임입니다."];
                } else {
                    $data = [1, ""];
                }
            }
            break;
        case "UserID": // 이메일 검사
            if (strlen($value) < 1) {
                $data = [-1, "어서 작성해 주세요."];
            } else if (strlen($value) > 320) {
                $data = [0, "너무 깁니다."];
            } else if (strpos($value, "@") === false) {
                $data = [-1, "도메인까지 작성해 주세요~"];
            } else {
                $mysqli = mysqli_connect($config_db["host"], $config_db["user"], $config_db["password"], $config_db["database"]); {
                    $users_model = new Users($mysqli, $config_db["table"]);
                    $users_data = $users_model->load([["EMail", "=", $value], ["Authenticated", "=", 1]]);
                } $mysqli->close();

                if (isset($users_data)) {
                    $data = [0, "해당 이메일로 가입된 계정이 존재합니다."];
                } else {
                    $data = [1, "좋습니다."];
                }
            }
            break;
        case "Password": // 비밀번호 검사
            if (strlen($value) < 1 || strlen($valueCheck) < 1) {
                $data = [-1, ""];
            } else if ($value === $valueCheck) {
                $data = [1, ""];
            } else if (strpos($value, $valueCheck) === 0) {
                $data = [-1, ""];
            } else if (strlen($valueCheck) > 0) {
                $data = [0, "비밀번호를 다시 확인해 주세요."];
            } else {
                $data = [-1, ""];
            }
            break;
        default:
            $data = [1];
    }
    return $data;
}

$config_db = parse_ini_file("configs/database.ini");

if (is_null($checkAll)) { // 개별 검사
    $result = checkAccount($_POST["Key"], $_POST["Data"], $config_db);
} else { // 전체 검사
    $checkList = ["Nickname", "UserID", "Password"];
    foreach ($checkList as $item) {
        $result = checkAccount($item, $input, $config_db);
        if ($result[0] !== 1) { // 검사에 통과하지 못한 경우
            $result = [$item, addslashes(json_encode($result))];
            break;
        }
    }

    if ($result[0] === 1) // 마지막 검사까지 통과한 경우
        $result = 1;
}

if ($printData !== false)
    print(json_encode($result));
?>
