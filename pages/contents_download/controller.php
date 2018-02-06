<?php
require_once('models/categories.php');
require_once('models/contents.php');

$id = $_GET['id'];

$config_contents = parse_ini_file("configs/contents.ini");

$contents_model = new Contents(null, null, null, $id);
$contents_data = $contents_model->getContents();
$datum = $contents_data[0];

$os = getOSName();
if ($os == 'Android' && strlen($datum['DownloadURL_Android']) !== 0) {
    print($datum['DownloadURL_Android']);
} else if ($os == 'Mac/iOS' && strlen($datum['DownloadURL_iOS']) !== 0) {
    print($datum['DownloadURL_iOS']);
} else if (strlen($datum['DownloadURL']) !== 0) {
    if(file_exists("{$_SERVER['DOCUMENT_ROOT']}{$config_contents['path']['root']}/{$datum['Identifier']}/{$datum['DownloadURL']}")) {
        print("{$config_contents['path']['root']}/{$datum['Identifier']}/{$datum['DownloadURL']}");
    } else {
        print($datum['DownloadURL']);
    }
}

function getOSName() {
    $userAgent = $_SERVER['HTTP_USER_AGENT'];
    if (strpos($userAgent, 'Windows NT 10.0') !== false) return 'Windows 10';
    else if (strpos($userAgent, 'Windows NT 6.2') !== false) return 'Windows 8';
    else if (strpos($userAgent, 'Windows NT 6.1') !== false) return 'Windows 7';
    else if (strpos($userAgent, 'Windows NT 6.0') !== false) return 'Windows Vista';
    else if (strpos($userAgent, 'Windows NT 5.1') !== false) return 'Windows XP';
    else if (strpos($userAgent, 'Windows NT 5.0') !== false) return 'Windows 2000';
    else if (strpos($userAgent, 'Mac') !== false) return 'Mac/iOS';
    else if (strpos($userAgent, 'X11') !== false) return 'UNIX';
    else if (strpos($userAgent, 'Android') !== false) return 'Android';
    else if (strpos($userAgent, 'Linux') !== false) return 'Linux';
    return 'Unknown';
}
?>
