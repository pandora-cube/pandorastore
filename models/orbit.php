<?php
class Orbit {
    private $mysqli;
    private $table;
    private $data;

    public function __construct() {
        $config_db = parse_ini_file("configs/database.ini");

        $this->mysqli = mysqli_connect($config_db["host"], $config_db["user"], $config_db["password"], $config_db["database"]);
        $this->table = $config_db["table"];

        if ($this->mysqli)
            $this->load();
    }

    public function load() {
        $sql = "
            SELECT *
            FROM {$this->table["orbit"]}
            WHERE Actived = 1
            ORDER BY ID ASC";

        $this->data = [];
        if ($result = $this->mysqli->query($sql)) {
            for ($i = 0; $i < $result->num_rows; $i++)
                $this->data[$i] = $result->fetch_assoc();
            $result->free();
        }
        return $this->data;
    }

    public function getData() {
        return $this->data;
    }
}
?>
