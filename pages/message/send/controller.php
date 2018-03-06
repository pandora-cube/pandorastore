<?php
require_once("models/messages.php");

$receiverNumber = $_POST["receiverNumber"];
$subject = $_POST["subject"];
$result = $_POST["result"];

$messages = new Messages();
$message->send($receiverNumber, $subject, $result);
?>
