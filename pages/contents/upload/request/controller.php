<?php
require_once("models/team.php");
require_once("models/contents.php");
require_once("models/categories.php");

$config_contents = parse_ini_file("configs/contents.ini");

$title = $_POST["Title"];
$identifier = $_POST["Identifier"];
$introduction = $_POST["Introduction"];

$uploadedFiles = uploadFiles($config_contents, $identifier);
$teamID = insertTeam();
insertContents($teamID, $uploadedFiles, $title, $identifier, $creator, $introduction);

function uploadFiles($config_contents, $identifier) {
    $MAX_FILE_SIZE = $config_contents["MAX_FILE_SIZE"];
    $MAX_FILE_SIZE_MB = $MAX_FILE_SIZE / 1024 / 1024;
    $numScreenShot = 0;

    $uploadedFiles = ["File" => [], "Image" => []];
    foreach ($_FILES as $key => $file) {
        if ($file["size"] === 0) {
            // 업로드되지 않은 경우
            continue;
        } else if ($file["size"] > $MAX_FILE_SIZE) {
            // 제한 용량을 초과한 경우
            exit("{$MAX_FILE_SIZE_MB}MB를 초과한 파일은 업로드할 수 없습니다.");
        } else {
            // 업로드 성공
            $fileDest = getcwd()."{$config_contents["path"]["root"]}/{$identifier}"; // 파일 디렉토리
            $fileName = basename($file["name"]); // 파일 이름

            // 디렉토리 생성
            $dirResult = mkdir($fileDest, 0777, true);
            if (is_dir($fileDest) === false && $dirResult === false) {
                exit("콘텐츠 디렉토리를 생성하지 못했습니다.");
            }

            if (strpos($key, "File-") === 0) { // 콘텐츠 파일인 경우
                $index = substr($key, strlen("File-"), strlen($key));

                // 플랫폼 이름
                $categories_model = new Categories();
                $platform = $categories_model->getPlatformNameById(intval($_POST["Platform-{$index}"]));

                // 파일 이동
                $fileMoveDest = "{$fileDest}/{$fileName}.Platform_{$platform}";
                move_uploaded_file($file["tmp_name"], $fileMoveDest);

                // 다운로드 URL
                $fileURL = "/contents/download?identifier={$identifier}&platform={$platform}&filename={$fileName}";
                $uploadedFiles["File"][$index] = $fileURL;
            } else if (strcmp($key, "Icon-File") === 0) { // 아이콘 파일인 경우
                // 파일 이동
                $fileMoveDest = "{$fileDest}/{$config_contents["image"]["thumbnail"]}";
                move_uploaded_file($file["tmp_name"], $fileMoveDest);

                // 아이콘 URL
                $uploadedFiles["Icon"] = "/{$fileMoveDest}";
            } else if (strpos($key, "Image-File-") === 0) { // 이미지 파일인 경우
                $index = substr($key, strlen("Image-File-"), strlen($key));
                $type = $_POST["Image-Type-{$index}"];

                // 이미지 디렉터리 생성
                mkdir("{$fileDest}/images", 0777, true);

                // 파일 이동
                $fileExtention = pathinfo($file["name"], PATHINFO_EXTENSION);
                $fileMoveDest = "{$fileDest}/images/{$numScreenShot}.{$fileExtention}";
                move_uploaded_file($file["tmp_name"], $fileMoveDest);
                $numScreenShot++;

                // 이미지 URL
                $uploadedFiles["Image"][$index] = "/{$fileMoveDest}";
            }
        }
    }

    return $uploadedFiles;
}

function insertTeam() {
    $numCreators = intval($_POST["Num-Creators"]);

    $creators = [];
    for ($i = 0; $i < $numCreators; $i++) {
        if (strlen($_POST["Creator-{$i}"]) < 1) {
            continue;
        }
        $creatorID = intval($_POST["Creator-{$i}"]);
        array_push($creators, $creatorID);
    }

    $team_model = new Team();
    $teamID = $team_model->insert($_POST["Creator-TeamName"], $creators);

    return $teamID;
}

function insertContents($teamID, $uploadedFiles, $title, $identifier, $creator, $introduction) {
    $creator = "T{$teamID}";

    // 장르 배열 처리
    $numGenres = intval($_POST["Num-Genres"]);
    $genres = [];
    for ($i = 0; $i < $numGenres; $i++) {
        if (strlen($_POST["Genre-{$i}"]) < 1) {
            continue;
        }
        $genreID = intval($_POST["Genre-{$i}"]);
        array_push($genres, $genreID);
    }

    // 플랫폼 배열 처리
    $numPlatforms = intval($_POST["Num-Files"]);
    $platforms = [];
    for ($i = 0; $i < $numPlatforms; $i++) {
        if (strlen($_POST["Platform-{$i}"]) < 1) {
            continue;
        }
        $platformID = intval($_POST["Platform-{$i}"]);
        array_push($platforms, $platformID);
    }

    // 다운로드 경로 맵 처리
    $categories_model = new Categories();
    $numFiles = intval($_POST["Num-Files"]);
    $downloads = [];
    for ($i = 0; $i < $numFiles; $i++) {
        $platform = $categories_model->getPlatformNameById(intval($_POST["Platform-{$i}"]));
        $url = $_POST["URL-{$i}"];
        $file = $uploadedFiles["File"][$i];

        if (strlen($file) > 0) {
            $downloads[$platform] = $file;
        } else {
            $downloads[$platform] = $url;
        }
    }

    // 콘텐츠 정보 등록
    $contents_model = new Contents();
    $contents_model->insert($title, $identifier, $genres, $platforms, $tags, $creator, $downloads, $introduction);
}
?>
