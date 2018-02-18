<?php
require_once("models/user.php");

/**
 * 전체 사이트에서 광범위하게 사용되는 로그 기능
 * 특정 범위에서만 사용되는 로그는 해당 모듈 내에 별도 구현
 */
class Logger {
    private $mysqli;
    private $table;
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
