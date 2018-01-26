<?php
class User {
    private $mysqli;
    private $table;
    private $userID;
    private $password;
    private $encrypt;
    private $data;

    public function __construct($userID, $password, $encrypt) {
        $config_db = parse_ini_file("configs/database.ini");

        $this->mysqli = mysqli_connect($config_db["host"], $config_db["user"], $config_db["password"], $config_db["database"]);
        $this->table = $config_db["table"];

        if ($this->mysqli)
            $this->load($userID, $password, $encrypt);
    }

    public function load($userID, $password, $encrypt) {
        $userID = $this->mysqli->escape_string($userID);
        $password = $this->mysqli->escape_string($password);

        $con_password = ($encrypt) ? "Password = SHA1('{$password}')" : "Password = '{$password}'";

        $sql = "
            SELECT *
            FROM {$this->table["users"]}
            WHERE UserID = '{$userID}' AND {$con_password}";

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

    public function update($userID, $inputData) {


        foreach ($inputData as $key => $value) {
        }
    }
}
?>
