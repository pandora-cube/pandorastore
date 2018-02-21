<?php
require_once("models/user.php");

class Log {
    private $mysqli;
    private $table;
    private $data;
    private $userIP;
    private $userNumber;
    private $browser;

    public function __construct() {
        $config_db = parse_ini_file("configs/database.ini");

        $this->mysqli = mysqli_connect($config_db["host"], $config_db["user"], $config_db["password"], $config_db["database"]);
        $this->table = $config_db["table"];

        session_start();
        $user_data = null;
        if (isset($_SESSION["UserID"]) && isset($_SESSION["Password"])) {
            $user_model = new User($_SESSION["UserID"], $_SESSION["Password"], false);
            $user_data = $user_model->getData();
        }
        $this->userIP = $this->mysqli->escape_string($_SERVER["REMOTE_ADDR"]);
        $this->userNumber = ($user_data !== null) ? $user_data["UserNumber"] : "NULL";
        $this->browser = get_browser(null, true)["parent"];
    }

    public function load($table, $conditions) {
        $sql = "
            SELECT *
            FROM {$this->table[$table]}";

        if (count($conditions) > 0) {
            $sql = " WHERE TRUE";
            foreach ($conditions as $condition) {
                $value = $this->mysqli->escape_string($condition[2]);
                $sql .= " AND ({$condition[0]} {$condition[1]} '{$value}')";
            }
        }

        $this->data = [];
        if ($result = $this->mysqli->query($sql)) {
            while ($datum = $result->fetch_assoc())
                array_push($this->data, $datum);
            $result->free();
        }
        return $this->data;
    }

    public function getData() {
        return $this->data;
    }

    public function logNavigation() {
        $url = $this->mysqli->escape_string("{$_SERVER["HTTP_HOST"]}{$_SERVER["REQUEST_URI"]}");

        $sql = "
            INSERT INTO {$this->table["log_navigation"]} (UserNumber, UserIP, URL, Browser)
            VALUES ({$this->userNumber}, '{$this->userIP}', '{$url}', '{$this->browser}')";
        
        $this->mysqli->query($sql);
    }

    public function logSignIn($userNumber, $success) {
        $userNumber = ($userNumber !== null) ? intval($userNumber) : "NULL";
        $success = intval($success);
        $host = $this->mysqli->escape_string($_SERVER["HTTP_HOST"]);

        $sql = "
            INSERT INTO {$this->table["log_signin"]} (UserNumber, UserIP, Success, Host, Browser)
            VALUES ({$userNumber}, '{$this->userIP}', {$success}, '{$host}', '{$this->browser}')";
        
        $this->mysqli->query($sql);
    }
}
?>
