<?php
require_once("models/messages.php");

$recents = $_GET["recents"];

$messages = new Messages();
if ($recents)
    $messages->loadRecents(null);
else
    $messages->load(null);
print(json_encode($messages->getData()));
?>
