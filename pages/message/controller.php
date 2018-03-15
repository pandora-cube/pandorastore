<?php
require_once("libraries/functions/template.php");

$template = new Template();
if (isset($_GET["to"])) {
    $template->setAttribute("to", $_GET["to"]);
} else {
    $template->disableArea("load-message-view");
}
$template->loadView("message");
?>
