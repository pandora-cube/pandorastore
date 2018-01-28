<?php
class User {
    private $mysqli;
    private $table;
    private $data;

    public function __construct($userID, $password, $encrypt, $compel = false) {
        $config_db = parse_ini_file("configs/database.ini");

        $this->mysqli = mysqli_connect($config_db["host"], $config_db["user"], $config_db["password"], $config_db["database"]);
        $this->table = $config_db["table"];

        if ($this->mysqli)
            $this->load($userID, $password, $encrypt, $compel);
    }

    public function load($userID, $password, $encrypt, $compel) {
        $userID = $this->mysqli->escape_string($userID);
        $password = $this->mysqli->escape_string($password);

        $con_password = ($encrypt) ? "Password = SHA1('{$password}')" : "Password = '{$password}'";

        $sql = "
            SELECT *
            FROM {$this->table["users"]}
            WHERE UserID = '{$userID}'";
        if ($compel !== true)
            $sql .= " AND {$con_password}";

        $this->data = null;
        if ($result = $this->mysqli->query($sql)) {
            if ($result->num_rows > 0)
                $this->data = $result->fetch_assoc();
            $result->free();
        }
        return $this->data;
    }

    public function getData() {
        return $this->data;
    }

    public function update($inputData) {
        if (count($inputData) < 1 || is_null($this->data)) {
            return false;
        }

        $sql = "
            UPDATE {$this->table["users"]} SET
                UpdatedTime = CURRENT_TIMESTAMP";

        foreach ($inputData as $key => $value) {
            if (gettype($value) === "string")
                $value = "'{$value}'";
            $key = $this->mysqli->escape_string($key);
            $value = $this->mysqli->escape_string($value);
            $sql .= ", {$key} = {$value}";
        }
        $sql .= " WHERE UserNumber = {$this->data["UserNumber"]}";

        return $this->mysqli->query($sql);
    }
}
?>
