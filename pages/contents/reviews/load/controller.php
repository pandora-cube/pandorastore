<?php
require_once("models/reviews.php");

$content = $_GET["content"];

$reviews = new Reviews($content);
print(json_encode($reviews->getData()));
?>
