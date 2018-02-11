<?php
require_once("models/reviews.php");

$content = $_GET["content"];
$result = $_GET["result"];

$reviews = new Reviews($content);
$reviews->write($result);
?>
