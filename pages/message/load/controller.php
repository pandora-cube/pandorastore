<?php
require_once("models/messages.php");

$recents = $_GET["Recents"];
$senderNumber = $_GET["SenderNumber"];
$updateToRead = $_GET["UpdateToRead"];

$messages = new Messages();
if ($recents)
    $messages->loadRecents(null);
else
    $messages->load(null, $senderNumber, $updateToRead);
print(json_encode($messages->getData()));
?>
