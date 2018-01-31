<?php
/*
 *      [Pandora Cube contents store]
 * 
 *          Pandora Store
 *          v1.04
 * 
 *      First Release:  2017.06.18
 *      Last Update:    2018.01.31
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
if(is_file("pages/$action/controller.php")) {
    $logEnabled = true;
    require("pages/$action/controller.php");
    if ($logEnabled) {
        $logger = new Logger();
        $logger->logPaging();
    }
} else {
    $action = "main";
    goto loop;
}
?>
