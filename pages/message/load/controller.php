<?php
require_once("models/messages.php");

$recents = $_GET["Recents"];
$senderNumber = $_GET["SenderNumber"];

$messages = new Messages();
if ($recents)
    $messages->loadRecents(null);
else
    $messages->load(null, $senderNumber);
print(json_encode($messages->getData()));
?>
