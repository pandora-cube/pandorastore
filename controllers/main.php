<?php
require_once("template.php");
require_once("models/orbit.php");
require_once("models/categories.php");
require_once("models/contents.php");

$category = $_GET["category"];
preg_match("/G([0-9]+)/", $category, $genre);
preg_match("/P([0-9]+)/", $category, $platform);
preg_match("/T([0-9]+)/", $category, $tag);
$genre = (count($genre) < 2) ? null : $genre[1];
$platform = (count($platform) < 2) ? null : $platform[1];
$tag = (count($tag) < 2) ? null : $tag[1];

$search = $_GET["search"];

$config_db = parse_ini_file("configs/database.ini");
$mysqli = mysqli_connect($config_db["host"], $config_db["user"], $config_db["password"], $config_db["database"]); {
    $orbit_model = new Orbit($mysqli, $config_db["table"]);
    $categories_model = new Categories($mysqli, $config_db["table"]);
    $contents_model = new Contents();

    $orbit_data = $orbit_model->load();
    $categories_data = $categories_model->load();
    $tags_data = $categories_model->loadTags();
    $contents_data = $contents_model->load($genre, $platform, $tag, null, $search);

    $genre_name = &$categories_data["Genre"][$genre];
    $platform_name = &$categories_data["Platform"][$platform];
    $tag_name = &$categories_data["Tag"][$tag];
    if (isset($search))
        $category_name = "검색 결과 - {$search}";
    else if(isset($genre_name) && isset($platform_name))
        $category_name = "{$genre_name} / {$platform_name}";
    else if(isset($genre_name))
        $category_name = $genre_name;
    else if(isset($platform_name))
        $category_name = $platform_name;
    else if(isset($tag_name))
        $category_name = $tag_name;
    else
        $category_name = null;
} $mysqli->close();

$template = new Template();
$template->setAttribute("orbit", $orbit_data);
$template->setAttribute("contents", $contents_data);
$template->setAttribute("category_name", $category_name);
$template->setAttribute("tags", $tags_data);
$template->setAttribute("search", addslashes($search));
$template->loadView("main");
?>
