<?php
require_once("libraries/functions/template.php");

$config_contents = parse_ini_file("configs/contents.ini");

$template = new Template("판도라스토어 콘텐츠 등록");
$template->setAttribute("MAX_FILE_SIZE", $config_contents["MAX_FILE_SIZE"]);
$template->loadView("contents/upload/form");
?>
