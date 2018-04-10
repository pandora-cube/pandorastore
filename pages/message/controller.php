<?php
require_once("libraries/functions/template.php");

$template = new Template("판도라스토어 메시지"");
if (isset($_GET["to"])) {
    $template->setAttribute("to", $_GET["to"]);
} else {
    $template->disableArea("load-message-view");
}
$template->loadView("message");
?>
