<?php
class Users {
    private $mysqli;
    private $table;
    private $data;

    public function __construct($link, $table) {
        $this->mysqli = $link;
        $this->table = $table;
    }

    public function load($conditions) {
        $sql = "
            SELECT *
            FROM {$this->table["users"]}";
        
        if (count($conditions) > 0) {
            $sql .= " WHERE TRUE";
            foreach ($conditions as $condition) {
                $value = $this->mysqli->escape_string($condition[2]);
                $sql .= " AND ({$condition[0]} {$condition[1]} '{$value}')";
            }
        }
        
        $this->data = null;
        if ($result = $this->mysqli->query($sql)) {
            if ($result->num_rows > 0)
                $this->data = $result->fetch_assoc();
            $result->free();
        }
        return $this->data;
    }
}
?>
