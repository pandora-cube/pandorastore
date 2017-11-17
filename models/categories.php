<?php
class Categories {
    private $mysqli;
    private $table;
    private $names;

    public function __construct($link, $table) {
        $this->mysqli = $link;
        $this->table = $table;
    }

    public function load() {
        $sql = "
            SELECT *, \"Genre\" AS Type
            FROM {$this->table["genres"]}
            UNION
            SELECT *, \"Platform\" AS Type
            FROM {$this->table["platforms"]}
            UNION
            SELECT *, \"Tag\" AS Type
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

    public function parseArray($origin, &$data, $type) {
        $data[$type."sID"] = explode(',', $origin[$type.'s']);
    }

    public function parseName($origin, &$data, $type) {
        $result = array();
        foreach(explode(',', $origin[$type.'s']) as $id)
            array_push($result, $this->names[$type][$id]);
        $data[$type.'s'] = $result;
    }
}
?>
