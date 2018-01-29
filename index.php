<?php
/*
 *      [Pandora Cube contents store]
 * 
 *          Pandora Store
 *          v1.03.4
 * 
 *      First Release:  2017.06.18
 *      Last Update:    2018.01.29
 * 
 *      Coded by Seongbum @ All rights reserved.
 *          sBum.Seo@gmail.com
 *          http://seongbum.com
 *          http://store.p-cube.kr
 * 
 */

require_once("logger.php");

$action = $_GET["action"];

loop:
if(is_file("controllers/$action.php")) {
    // 페이징 로그
    $logger = new Logger();
    $logger->logPaging();

    require("controllers/$action.php");
} else {
    $action = "main";
    goto loop;
}
?>
