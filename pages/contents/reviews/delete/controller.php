<?php
require_once("models/reviews.php");

$review = $_POST["review"];

$reviews = new Reviews();
$reviews->delete($review);
?>
