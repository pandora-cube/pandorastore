<?php
require("models/orbit.php");
require("models/games.php");
$dbconfig = parse_ini_file("configs/database.ini");

$mysqli = mysqli_connect($dbconfig["host"], $dbconfig["user"], $dbconfig["password"], $dbconfig["database"]);

$orbit = new Orbit($mysqli, $dbconfig["table"]);
$orbit = $orbit->load();

$games = new Games($mysqli, $dbconfig["table"]);
$games = $games->load();

$mysqli->close();

require("views/main.php");
?>
