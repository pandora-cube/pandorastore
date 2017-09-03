<?php
require("template.php");
require("models/orbit.php");
require("models/categories.php");
require("models/contents.php");

$category = $_GET["category"];
preg_match("/G([0-9]+)/", $category, $genre);
preg_match("/P([0-9]+)/", $category, $platform);
$genre = (count($genre) < 2) ? NULL : $genre[1];
$platform = (count($platform) < 2) ? NULL : $platform[1];

$config_db = parse_ini_file("configs/database.ini");
$config_contents = parse_ini_file("configs/contents.ini");
$mysqli = mysqli_connect($config_db["host"], $config_db["user"], $config_db["password"], $config_db["database"]); {
	$orbit_model = new Orbit($mysqli, $config_db["table"]);
	$categories_model = new Categories($mysqli, $config_db["table"]);
	$contents_model = new contents($mysqli, $config_db["table"], $config_contents, $categories_model);

	$orbit_data = $orbit_model->load();
	$categories_data = $categories_model->load();
	$contents_data = $contents_model->load($genre, $platform);

	$genre_name = &$categories_data["Genre"][$genre];
	$platform_name = &$categories_data["Platform"][$platform];
	if(isset($genre_name) && isset($platform_name))
		$category_name = "{$genre_name} / {$platform_name}";
	else if(isset($genre_name))
		$category_name = $genre_name;
	else if(isset($platform_name))
		$category_name = $platform_name;
	else
		$category_name = "전체 콘텐츠";
} $mysqli->close();

$template = new Template();
$template->setAttribute("orbit", $orbit_data);
$template->setAttribute("contents", $contents_data);
$template->setAttribute("category_name", $category_name);
$template->loadView("main");
?>
