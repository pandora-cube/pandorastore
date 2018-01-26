<?php
/*
 *      [Pandora Cube contents store]
 * 
 *          Pandora Store
 *          v1.03.2
 * 
 *      First Release:  2017.06.18
 *      Last Update:    2017.12.30
 * 
 *      Coded by Seongbum @ All rights reserved.
 *          sBum.Seo@gmail.com
 *          http://seongbum.com
 *          http://store.p-cube.kr
 * 
 */

require_once("logger.php");
require_once("models/user.php");

$action = $_GET["action"];

// 설정 불러오기
$config_db = parse_ini_file("configs/database.ini");

// DB 접속
$mysqli = mysqli_connect($config_db["host"], $config_db["user"], $config_db["password"], $config_db["database"]);
if (!$mysqli) { // 실패 시
    return;
}

loop:
if(is_file("controllers/$action.php")) {
    // 페이징 로그
    $logger = new Logger($mysqli, $config_db["table"], $user);
    $logger->logPaging();

    require("controllers/$action.php");
} else {
    $action = "main";
    goto loop;
}
?>
