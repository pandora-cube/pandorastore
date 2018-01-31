<?php
require_once("functions/mail.php");

$mail = new Mail();
$mail->setSender("판도라스토어", "store@p-cube.kr");
$mail->setReceiver("서 성범", "pureunbano@naver.com");
$mail->setSubject("제목, Subject");
$mail->setMessage("<center>내용, <b>Message</b></center>");
echo (string)$mail->send();
?>
