<?php
require_once("models/contents.php");

$config_contents = parse_ini_file("configs/contents.ini");

$identifier = $_GET["identifier"];
$platform = $_GET["platform"];
$fileName = $_GET["filename"];

$filePath = getcwd()."{$config_contents["path"]["root"]}/{$identifier}/.Platform_{$platform}";
$fileSize = filesize($filePath);

header("Pragma: public");
header("Expires: 0");
header("Content-Type: application/octet-stream");
header("Content-Disposition: attachment; filename=\"{$fileName}\"");
header("Content-Transfer-Encoding: binary");
header("Content-Length: {$fileSize}");

ob_clean();
flush();
readfile($filePath);
?>
