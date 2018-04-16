<?php
require_once("libraries/functions/template.php");
require_once("models/user.php");
require_once("models/contents.php");

$template = null;

/* Contents */ {
    $contents = new Contents(null, null, null, $_GET["identifier"], null);
    $data = $contents->getContents()[0];

    $template = new Template("{$data["Title"]} - 판도라스토어 콘텐츠");

    // Creators
    if (strlen($data["Creators"]) === 0
    || $data["Creators"] === $data["Creator"])
        $template->disableArea("tooltip");

    // Downloads
    $template->setAttribute("download-data", $data["Downloads"]);

    // Whole data
    $template->addAttributes($data);
}

/* User */ {
    $user = new User();
    $user_data = $user->getData();
    if ($user_data["PCubeMember"] != 1)
        $template->disableArea("review-write");
}

$template->loadView("contents/detail");
?>
