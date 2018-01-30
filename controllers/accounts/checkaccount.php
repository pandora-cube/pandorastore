<?php
require_once("models/users.php");

function checkAccount($key, $input, &$checkList, $checkAll) {
    $data = [];
    $value = $input[$key];

    switch ($key) {
        case "Nickname": // 닉네임 검사
            if (strlen($value) < 1) {
                $data = ["Nickname", -1, ""];
            } else if (strlen($value) > 16) {
                $data = ["Nickname", 0, "너무 깁니다."];
            } else {
                $users_model = new Users([["Nickname", "=", $value], ["Authenticated", "=", 1]]);
                $users_data = $users_model->getData();

                if (count($users_data) > 0) {
                    $data = ["Nickname", 0, "이미 사용중인 닉네임입니다."];
                } else {
                    $data = ["Nickname", 1, ""];
                }
            }
            break;
        case "EMail": // 이메일 검사
            if (strlen($value) < 1) {
                $data = ["EMail", -1, ""];
            } else if (strlen($value) > 320) {
                $data = ["EMail", 0, "너무 깁니다."];
            } else if (strpos($value, "@") === false) {
                $data = ["EMail", -1, "도메인까지 작성해 주세요~"];
            } else {
                $users_model = new Users([["EMail", "=", $value], ["Authenticated", "=", 1]]);
                $users_data = $users_model->getData();

                if (count($users_data) > 0) {
                    $data = ["EMail", 0, "해당 이메일로 가입된 계정이 존재합니다."];
                } else {
                    $data = ["EMail", 1, "좋습니다."];
                }
            }
            break;
        case "Password": // 비밀번호 검사
        case "PasswordCheck":
            if (strlen($input["Password"]) < 1 || strlen($input["PasswordCheck"]) < 1) {
                $data = ["Password", -1, ""];
            } else if ($input["Password"] === $input["PasswordCheck"]) {
                $data = ["Password", 1, ""];
            } else if (strpos($input["Password"], $input["PasswordCheck"]) === 0) {
                $data = ["Password", -1, ""];
            } else if (strlen($input["PasswordCheck"]) > 0) {
                $data = ["Password", 0, "비밀번호를 다시 확인해 주세요."];
            } else {
                $data = ["Password", -1, ""];
            }
            break;
        case "PCubeMember": // 판도라큐브 회원 여부
            if ($value == true && $checkAll === true) {
                array_push($checkList, "LastName", "FirstName", "Univ", "StudentID", "Part");
            }
            $data = ["PCubeMember", 1, ""];
            break;
        case "LastName": // 성
        case "FirstName": // 이름
            if (strlen($input["LastName"]) < 1 || strlen($input["FirstName"]) < 1) {
                $data = ["Name", -1, ""];
            } else if (strlen($input["LastName"].$input["FirstName"]) > 16) {
                $data = ["Name", 0, "성명이 너무 깁니다."];
            } else {
                $data = ["Name", 1, ""];
            }
            break;
        case "Univ": // 소속 대학
        case "StudentID": // 학번
            if (strlen($input["Univ"]) < 1 || strlen($input["StudentID"]) < 1) {
                $data = ["Univ", -1, ""];
            } else if (strlen($input["Univ"]) > 32) {
                $data = ["Univ", 0, "대학명이 너무 깁니다."];
            } else if (strlen($input["StudentID"]) > 12) {
                $data = ["Univ", 0, "학번이 너무 깁니다."];
            } else {
                $users_model = new Users([["University", "=", $input["Univ"]], ["StudentID", "=", $input["StudentID"]], ["Authenticated", "=", 1]]);
                $users_data = $users_model->getData();

                if (count($users_data) > 0) {
                    $data = ["Univ", 0, "해당 대학 및 학번으로 가입된 계정이 존재합니다."];
                } else {
                    $data = ["Univ", 1, ""];
                }
            }
            break;
        case "ProgrammingPart": // 파트
        case "DesignPart":
        case "ArtPart":
            if ($value !== "true") {
                $data = ["Part", -1, ""];
            } else {
                $data = ["Part", 1, ""];
            }
            break;
        default:
            $data = [$key, 1, ""];
    }
    return $data;
}

$checkList = ["Nickname", "EMail", "Password", "PasswordCheck", "PCubeMember"];
if (is_null($checkAll)) { // 개별 검사
    $result = checkAccount($_POST["Key"], $_POST["Data"], $checkList, false);
} else { // 전체 검사
    foreach ($checkList as $item) {
        $result = checkAccount($item, $input, $checkList, true);
        if ($result[1] !== 1) { // 검사에 통과하지 못한 경우
            $result = [$item, addslashes(json_encode($result))];
            break;
        }
    }

    if ($result[1] === 1) // 마지막 검사까지 통과한 경우
        $result = 1;
}

if ($printData !== false)
    print(json_encode($result));
?>
