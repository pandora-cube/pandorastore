<?php
require_once("models/reviews.php");

$review = $_POST["review"];
$result = $_POST["result"];

$reviews = new Reviews();
$reviews->edit($review, $result);
?>
