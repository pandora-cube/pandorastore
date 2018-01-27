<?php
require_once("models/categories.php");

class Contents {
    private $mysqli;
    private $table;
    private $config;
    private $contents;

    public function __construct($genre = null, $platform = null, $tag = null, $id = null, $search = null) {
        $config_db = parse_ini_file("configs/database.ini");

        $this->mysqli = mysqli_connect($config_db["host"], $config_db["user"], $config_db["password"], $config_db["database"]);
        $this->table = $config_db["table"];
        $this->config = parse_ini_file("configs/contents.ini");

        if ($this->mysqli)
            $this->load($genre, $platform, $tag, $id, $search);
    }

    public function load($genre = null, $platform = null, $tag = null, $id = null, $search = null) {
        $genre = $this->mysqli->escape_string($genre);
        $platform = $this->mysqli->escape_string($platform);
        $tag = $this->mysqli->escape_string($tag);
        $id = $this->mysqli->escape_string($id);
        $search = $this->mysqli->escape_string($search);

        $con_genre = ($genre == null) ? "TRUE" : "CONCAT(\",\", Genres, \",\") LIKE \"%,{$genre},%\"";
        $con_platform = ($platform == null) ? "TRUE" : "CONCAT(\",\", Platforms, \",\") LIKE \"%,{$platform},%\"";
        $con_tag = ($tag == null) ? "TRUE" : "CONCAT(\",\", Tags, \",\") LIKE \"%,{$tag},%\"";
        $con_id = ($id == null) ? "TRUE" : "ID = {$id}";
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

            $con_genre = $con_platform = $con_tag = $con_id = "TRUE";
            $con_search = "MATCH(Title, Identifier, Creator) AGAINST('{$search}' IN BOOLEAN MODE)";
        }

        $sql = "
            SELECT *
            FROM {$this->table["contents"]}
            WHERE {$con_genre} AND {$con_platform} AND {$con_tag} AND {$con_id} AND {$con_search} AND Enabled = 1
            ORDER BY CreatedTime DESC";

        $categories_model = new Categories($this->mysqli, $config_db["table"]);
        $this->contents = array();
        if($result = $this->mysqli->query($sql)) {
            for($i = 0; $i < $result->num_rows; $i++) {
                $origin = $this->contents[$i] = $result->fetch_assoc();
                $identifier = $origin["Identifier"];

                // Thumbnail
                $this->contents[$i]["Thumbnail"] = $this->getPath($identifier)."/{$this->config["file"]["thumbnail"]}";
                // Images
                $this->contents[$i]["Images"] = $this->getImages($identifier);
                // Genres
                $categories_model->parseArray($origin, $this->contents[$i], "Genre");
                $categories_model->parseName($origin, $this->contents[$i], "Genre");
                // Platforms
                $categories_model->parseArray($origin, $this->contents[$i], "Platform");
                $categories_model->parseName($origin, $this->contents[$i], "Platform");
                // Tags
                $categories_model->parseArray($origin, $this->contents[$i], "Tag");
                $categories_model->parseName($origin, $this->contents[$i], "Tag");
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
}
?>
