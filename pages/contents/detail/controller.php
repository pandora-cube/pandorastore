<?php
require_once("libraries/functions/template.php");
require_once("models/user.php");
require_once("models/contents.php");

$template = new Template();

/* User */ {
    $user = new User();
    $user_data = $user->getData();
    if ($user_data["PCubeMember"] != 1)
        $template->disableArea("review-write");
}

/* Contents */ {
    $contents = new Contents(null, null, null, $_GET["identifier"], null);
    $data = $contents->getContents()[0];

    // Creators
    if (strlen($data["Creators"]) === 0
    || $data["Creators"] === $data["Creator"])
        $template->disableArea("tooltip");

    // Download URL
    $downloadConfig = [
        ["DownloadURL_Android", "Android"],
        ["DownloadURL_iOS", "iOS"],
        ["DownloadURL", "기타OS"],
    ];
    $downloadData = $downloadDatum = [];
    foreach ($downloadConfig as $config) {
        if (strlen($data[$config[0]]) > 0) {
            $downloadDatum["URL"] = $data[$config[0]];
            $downloadDatum["Text"] = $config[1];
            array_push($downloadData, $downloadDatum);
        }
    }
    $template->setAttribute("download-data", $downloadData);

    // Whole data
    $template->addAttributes($data);
}

$template->loadView("contents/detail");
?>
