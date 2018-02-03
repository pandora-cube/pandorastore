<?php
require_once("template.php");
require_once("models/users.php");
require_once("libraries/functions/mail.php");

// 입력 정보 해쉬맵 구성
$input = [];
foreach ($_POST as $key => $value)
    $input[$key] = $value;

// 입력 정보 검사
$printData = false;
$checkAll = true;
require("pages/accounts/signup_check/controller.php");

// 검사에 통과하지 못한 경우
if ($result !== 1) {
    setcookie("Error", json_encode($result), 0, "/accounts/");
    header("Location: /accounts/signup"); // 회원가입 페이지로 연결
    return;
}

// 데이터 전처리
$url_email = urlencode($_POST["EMail"]);
$html_nickname = htmlentities($_POST["Nickname"]);

// 인증코드 생성
$authCode = rand(100000, 999999); // 6자리 난수

// 인증 메일의 뷰 로드
$mailTemplate = new Template();
$mailTemplate->setAttribute("nickname", $html_nickname);
$mailTemplate->setAttribute("auth_code", $authCode);
$mailTemplate->setAttribute("auth_href", "http://{$_SERVER["HTTP_HOST"]}/accounts/signup_auth_action?email={$url_email}&authcode={$authCode}");
$mailView = $mailTemplate->loadView("accounts/signup_auth", false);

// 인증 메일 발송
$mail = new Mail();
$mail->setSender("판도라스토어", "store@p-cube.kr");
$mail->setReceiver($_POST["Nickname"], $_POST["EMail"]);
$mail->setSubject("판도라스토어 인증 코드입니다.");
$mail->setMessage($mailView);
$mail->send();

// 가입 요청
$users_model = new Users();
$users_model->request($input, $authCode);

// 인증코드 입력 페이지로 연결
setcookie("EMail", $_POST["EMail"], 0, "/accounts/");
header("Location: /accounts/signup_auth_input?email={$url_email}");
?>
