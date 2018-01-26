<?php
require_once("template.php");
require_once("models/users.php");
require_once("functions/mail.php");

$config_db = parse_ini_file("configs/database.ini");
$mysqli = mysqli_connect($config_db["host"], $config_db["user"], $config_db["password"], $config_db["database"]); {
    // 입력 정보 해쉬맵 구성
    $input = [];
    foreach ($_POST as $key => $value)
        $input[$key] = $value;

    // 입력 정보 검사
    $printData = false;
    $checkAll = true;
    require("checkaccount.php");

    // 검사에 통과하지 못한 경우
    if ($result !== 1) {
        $mysqli->close();
        setcookie("Error", json_encode($result), 0, "/accounts/");
        header("Location: /accounts/signup"); // 회원가입 페이지로 연결
        return;
    }

    // 인증코드 생성
    $authCode = rand(100000, 999999); // 6자리 난수

    // 인증 메일의 뷰 로드
    $mailTemplate = new Template();
    $mailTemplate->setAttribute("nickname", $_POST["Nickname"]);
    $mailTemplate->setAttribute("auth_code", $authCode);
    $mailView = $mailTemplate->loadView("accounts/signup_auth", false);

    // 인증 메일 발송
    $mail = new Mail();
    $mail->setSender("판도라스토어", "store@p-cube.kr");
    $mail->setReceiver($_POST["Nickname"], $_POST["UserID"]);
    $mail->setSubject("판도라스토어 인증 코드입니다.");
    $mail->setMessage($mailView);
    $mail->send();

    // 가입 요청
    $users_model = new Users();
    $users_model->request($input, $authCode);

    // 인증코드 입력 페이지로 연결
    setcookie("EMail", $_POST["UserID"], 0, "/accounts/");
    header("Location: /accounts/signup_auth_input?email={$_POST["UserID"]}");
} $mysqli->close();
?>
