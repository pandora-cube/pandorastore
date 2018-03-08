<?php
require_once("models/messages.php");

$receiverNumber = $_POST["receiverNumber"];
$result = $_POST["result"];

$messages = new Messages();
$message->send($receiverNumber, $result);
?>
