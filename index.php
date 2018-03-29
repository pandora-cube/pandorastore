<?php
/*
 *      [Pandora Cube contents store]
 * 
 *          Pandora Store
 *          v1.06.3
 * 
 *      First Release:  2017.06.18
 *      Last Update:    2018.03.29
 * 
 *      Coded by Seongbum @ All rights reserved.
 *          sBum.Seo@gmail.com
 *          http://seongbum.com
 *          http://p-store.kr
 * 
 */

require_once("models/log.php");

$action = $_GET["action"];

loop:
if(is_file("pages/$action/controller.php")) {
    $logEnabled = true;
    require("pages/$action/controller.php");
    if ($logEnabled) {
        $log = new Log();
        $log->logNavigation();
    }
} else {
    $action = "main";
    goto loop;
}
?>
