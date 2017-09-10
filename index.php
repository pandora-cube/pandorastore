<?php
$action = $_GET["action"];

loop:
if(is_file("controllers/$action.php")) {
    require("controllers/$action.php");
} else {
    $action = "main";
    goto loop;
}
?>
