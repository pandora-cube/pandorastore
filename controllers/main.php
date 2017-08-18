<?php
require("template.php");
require("models/orbit.php");
require("models/categories.php");
require("models/games.php");

$category = $_GET["category"];
preg_match("/G([0-9]+)/", $category, $genre);
preg_match("/P([0-9]+)/", $category, $platform);
$genre = (count($genre) < 2) ? NULL : $genre[1];
$platform = (count($platform) < 2) ? NULL : $platform[1];

$dbconfig = parse_ini_file("configs/database.ini");
$mysqli = mysqli_connect($dbconfig["host"], $dbconfig["user"], $dbconfig["password"], $dbconfig["database"]); {
	$orbit = new Orbit($mysqli, $dbconfig["table"]);
	$orbit = $orbit->load();

	$categories = new Categories($mysqli, $dbconfig["table"]);
	$games = new Games($mysqli, $dbconfig["table"], $categories);
	$games = $games->load($genre, $platform);
} $mysqli->close();

$template = new Template();
$template->setAttribute("orbit", $orbit);
$template->setAttribute("games", $games);
$template->loadView("main");
?>
