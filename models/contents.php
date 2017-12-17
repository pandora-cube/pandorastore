<?php
class Contents {
    private $mysqli;
    private $table;
    private $config;
    private $contents;
    private $categories_model;

    public function __construct($link, $table, $config, $categories_model) {
        $this->mysqli = $link;
        $this->table = $table;
        $this->config = $config;
        $this->categories_model = $categories_model;
    }

    public function load($genre = NULL, $platform = NULL, $tag = NULL, $id = NULL, $search = NULL) {
        $genre = $this->mysqli->escape_string($genre);
        $platform = $this->mysqli->escape_string($platform);
        $tag = $this->mysqli->escape_string($tag);
        $id = $this->mysqli->escape_string($id);
        $search = $this->mysqli->escape_string($search);

        $con_genre = ($genre == NULL) ? "TRUE" : "CONCAT(\",\", Genres, \",\") LIKE \"%,{$genre},%\"";
        $con_platform = ($platform == NULL) ? "TRUE" : "CONCAT(\",\", Platforms, \",\") LIKE \"%,{$platform},%\"";
        $con_tag = ($tag == NULL) ? "TRUE" : "CONCAT(\",\", Tags, \",\") LIKE \"%,{$tag},%\"";
        $con_id = ($id == NULL) ? "TRUE" : "ID = {$id}";
        /*$con_search = ($search == NULL) ? "TRUE" : "
            REGEXP_REPLACE(
                REGEXP_REPLACE(
                    TRIM(LOWER(Identifier)),
                    \"[^a-z,_, ,A-Z,0-9,ㄱ-ㅎ,가-힐,@,&,$,%,'']\", \"\"),
                \"[[:space:]]{1,}\", \" \")
            LIKE TRIM(LOWER(\"%{$search}%\"))";*/

        if ($search == NULL) {
            $con_search = "TRUE";
        } else {
            $con_genre = $con_platform = $con_tag = $con_id = "TRUE";
            $con_search = "MATCH(Title, Identifier, Creator) AGAINST('{$search}*' IN BOOLEAN MODE)";
        }

        $sql = "
            SELECT *
            FROM {$this->table["contents"]}
            WHERE {$con_genre} AND {$con_platform} AND {$con_tag} AND {$con_id} AND {$con_search} AND Enabled = 1
            ORDER BY CreatedTime DESC";

        $this->categories_model->load();
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
                $this->categories_model->parseArray($origin, $this->contents[$i], "Genre");
                $this->categories_model->parseName($origin, $this->contents[$i], "Genre");
                // Platforms
                $this->categories_model->parseArray($origin, $this->contents[$i], "Platform");
                $this->categories_model->parseName($origin, $this->contents[$i], "Platform");
                // Tags
                $this->categories_model->parseArray($origin, $this->contents[$i], "Tag");
                $this->categories_model->parseName($origin, $this->contents[$i], "Tag");
            }
            $result->free();
        }
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
