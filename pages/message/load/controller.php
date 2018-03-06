<?php
require_once("models/messages.php");

$onlyUnread = $_GET["onlyUnread"];

$messages = new Messages();
$messages->load(null, $onlyUnread);
print(json_encode($messages->getData()));
?>
