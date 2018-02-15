<?php
require_once("models/reviews.php");

$content = $_POST["content"];
$result = $_POST["result"];

$reviews = new Reviews($content);
$reviews->write($result);
?>
