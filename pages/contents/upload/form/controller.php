<?php
require_once("libraries/functions/template.php");
require_once("models/categories.php");

$config_contents = parse_ini_file("configs/contents.ini");

/* 장르 및 플랫폼 데이터 로드 */ {
    $categories_model = new Categories();
    $genres_data = $categories_model->getGenres();
    $platforms_data = $categories_model->getPlatforms();
}

$template = new Template("판도라스토어 콘텐츠 등록");
$template->setAttribute("MAX_FILE_SIZE", $config_contents["MAX_FILE_SIZE"]);
$template->setAttribute("genres", $genres_data);
$template->setAttribute("platforms", $platforms_data);
$template->loadView("contents/upload/form");
?>
