<?php
class Categories {
    private $mysqli;
    private $table;
    private $names;
    private $genres;
    private $platforms;
    private $tags;

    public function __construct() {
        $config_db = parse_ini_file("configs/database.ini");

        $this->mysqli = mysqli_connect($config_db["host"], $config_db["user"], $config_db["password"], $config_db["database"]);
        $this->table = $config_db["table"];

        if ($this->mysqli) {
            $this->loadNames();
            $this->loadGenres();
            $this->loadPlatforms();
            $this->loadTags();
        }
    }

    public function loadNames() {
        $sql = "
            SELECT ID, Name, 'Genre' AS Type
            FROM {$this->table["genres"]}
            UNION
            SELECT ID, Name, 'Platform' AS Type
            FROM {$this->table["platforms"]}
            UNION
            SELECT ID, Name, 'Tag' AS Type
            FROM {$this->table["tags"]}";

        $this->names = array();
        if($result = $this->mysqli->query($sql)) {
            for($i = 0; $i < $result->num_rows; $i++) {
                $data = $result->fetch_assoc();
                $this->names[$data["Type"]][$data["ID"]] = $data["Name"];
            }
            $result->free();
        }
        return $this->names;
    }

    public function loadGenres() {
        $sql = "
            SELECT *
            FROM {$this->table["genres"]}
            ORDER BY ID ASC";
        
        $this->genres = array();
        if($result = $this->mysqli->query($sql)) {
            for($i = 0; $i < $result->num_rows; $i++) {
                $this->genres[$i] = $result->fetch_assoc();
            }
            $result->free();
        }
        return $this->genres;
    }

    public function loadPlatforms() {
        $sql = "
            SELECT *
            FROM {$this->table["platforms"]}
            ORDER BY ID ASC";
        
        $this->platforms = array();
        if($result = $this->mysqli->query($sql)) {
            for($i = 0; $i < $result->num_rows; $i++) {
                $this->platforms[$i] = $result->fetch_assoc();
            }
            $result->free();
        }
        return $this->platforms;
    }

    public function loadTags() {
        $sql = "
            SELECT *
            FROM {$this->table["tags"]}
            ORDER BY ID ASC";

        $this->tags = array();
        if($result = $this->mysqli->query($sql)) {
            for($i = 0; $i < $result->num_rows; $i++) {
                $this->tags[$i] = $result->fetch_assoc();
            }
            $result->free();
        }
        return $this->tags;
    }

    public function getNames() {
        return $this->names;
    }

    public function getGenres() {
        return $this->genres;
    }

    public function getPlatforms() {
        return $this->platforms;
    }

    public function getTags() {
        return $this->tags;
    }

    public function parseArray($origin, &$data, $type) {
        $data["{$type}sID"] = explode(',', $origin["{$type}s"]);
    }

    public function parseName($origin, &$data, $type) {
        $result = array();
        foreach(explode(',', $origin["{$type}s"]) as $id)
            array_push($result, $this->names[$type][$id]);
        $data["{$type}s"] = $result;
    }
}
?>
