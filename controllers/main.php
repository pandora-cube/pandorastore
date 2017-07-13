<?php
require("models/OrbitModel.php");
$dbconfig = parse_ini_file("configs/database.ini");

$mysqli = mysqli_connect($dbconfig["host"], $dbconfig["user"], $dbconfig["password"], $dbconfig["database"]);
$orbit = new OrbitModel($mysqli);
$orbit = $orbit->load($dbconfig["table"]["orbit"]);
$mysqli->close();

require("views/main.php");
?>
