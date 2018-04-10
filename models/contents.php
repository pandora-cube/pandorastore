<?php
require_once("models/categories.php");
require_once("models/team.php");
require_once("models/user.php");

class Contents {
    private $mysqli;
    private $table;
    private $config;
    private $contents;

    public function __construct($genre = null, $platform = null, $tag = null, $identifier = null, $search = null) {
        $config_db = parse_ini_file("configs/database.ini");

        $this->mysqli = mysqli_connect($config_db["host"], $config_db["user"], $config_db["password"], $config_db["database"]);
        $this->table = $config_db["table"];
        $this->config = parse_ini_file("configs/contents.ini");

        if ($this->mysqli)
            $this->load($genre, $platform, $tag, $identifier, $search);
    }

    public function load($genre = null, $platform = null, $tag = null, $identifier = null, $search = null) {
        $genre = $this->mysqli->escape_string($genre);
        $platform = $this->mysqli->escape_string($platform);
        $tag = $this->mysqli->escape_string($tag);
        $identifier = $this->mysqli->escape_string($identifier);
        $search = $this->mysqli->escape_string($search);

        $con_genre = ($genre == null) ? "TRUE" : "CONCAT(\",\", Genres, \",\") LIKE \"%,{$genre},%\"";
        $con_platform = ($platform == null) ? "TRUE" : "CONCAT(\",\", Platforms, \",\") LIKE \"%,{$platform},%\"";
        $con_tag = ($tag == null) ? "TRUE" : "CONCAT(\",\", Tags, \",\") LIKE \"%,{$tag},%\"";
        $con_identifier = ($identifier == null) ? "TRUE" : "Identifier = \"{$identifier}\"";
        /*$con_search = ($search == null) ? "TRUE" : "
            REGEXP_REPLACE(
                REGEXP_REPLACE(
                    TRIM(LOWER(Identifier)),
                    \"[^a-z,_, ,A-Z,0-9,ㄱ-ㅎ,가-힐,@,&,$,%,'']\", \"\"),
                \"[[:space:]]{1,}\", \" \")
            LIKE TRIM(LOWER(\"%{$search}%\"))";*/

        if ($search == null) {
            $con_search = "TRUE";
        } else {
            preg_match_all('/(".*?"|\S+)/', $search, $matches);
            $matches = $matches[0];

            foreach ($matches as &$value) {
                $option = substr(stripslashes($value), 0, 1);
                if ($option != "-" && $option != "+" && $option != "\"")
                    $value .= "*";
            }
            $search = implode(" ", $matches);

            $con_genre = $con_platform = $con_tag = $con_identifier = "TRUE";
            $con_search = "MATCH(Title, Identifier, Creator) AGAINST('{$search}' IN BOOLEAN MODE)";
        }

        $sql = "
            SELECT *
            FROM {$this->table["contents"]}
            WHERE {$con_genre} AND {$con_platform} AND {$con_tag} AND {$con_identifier} AND {$con_search} AND Enabled = 1
            ORDER BY CreatedTime DESC";

        $categories_model = new Categories();
        $this->contents = array();
        if($result = $this->mysqli->query($sql)) {
            for($i = 0; $i < $result->num_rows; $i++) {
                $origin = $this->contents[$i] = $result->fetch_assoc();
                $identifier = $origin["Identifier"];

                // Thumbnail
                $this->contents[$i]["Thumbnail"] = $this->getPath($identifier)."/{$this->config["file"]["thumbnail"]}";
                $this->contents[$i]["ThumbnailAlt"] = $origin["Title"] + " 썸네일 이미지";
                if (!file_exists(".{$this->contents[$i]["Thumbnail"]}"))
                    $this->contents[$i]["Thumbnail"] = $this->config["file"]["thumbnail_none"];
                // Images
                $this->contents[$i]["Images"] = $this->getImages($identifier);
                if (count($this->contents[$i]["Images"]) === 0) {
                    $this->contents[$i]["Images"] = [$this->config["file"]["image_none"]];
                    $this->contents[$i]["ImagesTitle"] = ["등록된 이미지가 없습니다."];
                }
                // Creator
                $this->contents[$i]["Creators"] = $this->getCreators($this->contents[$i]["Creator"]);
                // Genres
                $categories_model->parseArray($origin, $this->contents[$i], "Genre");
                $categories_model->parseName($origin, $this->contents[$i], "Genre");
                $this->contents[$i]["GenresList"] = implode(", ", $this->contents[$i]["Genres"]);
                // Platforms
                $categories_model->parseArray($origin, $this->contents[$i], "Platform");
                $categories_model->parseName($origin, $this->contents[$i], "Platform");
                $this->contents[$i]["PlatformsList"] = implode(", ", $this->contents[$i]["Platforms"]);
                // Tags
                $categories_model->parseArray($origin, $this->contents[$i], "Tag");
                $categories_model->parseName($origin, $this->contents[$i], "Tag");
                $this->contents[$i]["TagsList"] = implode(", ", $this->contents[$i]["Tags"]);
                // Downloads
                $this->contents[$i]["Downloads"] = json_decode($this->contents[$i]["Downloads"]);
                foreach ($this->contents[$i]["Downloads"] as $platform => &$url) {
                    if (strpos($url, "http://") === false && strpos($url, "https://") === false) {
                        $url = $this->getPath($identifier)."/{$url}";
                    }
                }
            }
            $result->free();
        }
        return $this->contents;
    }

    public function getContents() {
        return $this->contents;
    }

    public function filterCategory($category_id, $type) {
        foreach($this->contents as $key => $content)
            if(!in_array($category_id, $content[$type."sID"]))
                unset($this->contents[$key]);
        return $this->contents;
    }

    private function getPath($identifier) {
        return "{$this->config["path"]["root"]}/$identifier";
    }

    private function getImages($identifier) {
        $globalpath = $this->getPath($identifier).$this->config["path"]["images"];
        $localpath = $_SERVER["DOCUMENT_ROOT"].$globalpath;
        $scan = scandir($localpath);
        $files = array();

        foreach($scan as $file) {
            if(is_file("{$localpath}/{$file}"))
                array_push($files, "{$globalpath}/{$file}");
        }

        return $files;
    }

    private function getCreators(&$creator) {
        $creators = json_decode($creator);
        $type = substr($creators, 0, 1);
        $number = intval(substr($creators, 1, strlen($creators)-1));

        if (gettype($creators) === "string") {
            if ($type === "T") {
                $team_model = new Team($number);
                $team_data = $team_model->getData();

                $creator = (strlen($team_data["Name"]) > 0) ? $team_data["Name"] : $team_data["MembersList"];
                $creators = $team_data["MembersList"];
            } else if ($type === "U") {
            }
        }

        return $creators;
    }
}
?>
