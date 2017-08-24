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
	$orbit_model = new Orbit($mysqli, $dbconfig["table"]);
	$categories_model = new Categories($mysqli, $dbconfig["table"]);
	$games_model = new Games($mysqli, $dbconfig["table"], $categories_model);

	$orbit_data = $orbit_model->load();
	$categories_data = $categories_model->load();
	$games_data = $games_model->load($genre, $platform);

	$genre_name = &$categories_data["Genre"][$genre];
	$platform_name = &$categories_data["Platform"][$platform];
	if(isset($genre_name) && isset($platform_name))
		$category_name = "{$genre_name} / {$platform_name}";
	else if(isset($genre_name))
		$category_name = $genre_name;
	else if(isset($platform_name))
		$category_name = $platform_name;
	else
		$category_name = "전체 목록";
} $mysqli->close();

$template = new Template();
$template->setAttribute("orbit", $orbit_data);
$template->setAttribute("games", $games_data);
$template->setAttribute("category_name", $category_name);
$template->loadView("main");
?>
