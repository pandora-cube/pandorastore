<?php
require_once("models/user.php");

/**
 * 전체 사이트에서 광범위하게 사용되는 로그 기능
 * 특정 범위에서만 사용되는 로그는 해당 모듈 내에 별도 구현
 */
class Logger {
    private $mysqli;
    private $table;
    private $user_data;

    public function __construct() {
        $config_db = parse_ini_file("configs/database.ini");

        $this->mysqli = mysqli_connect($config_db["host"], $config_db["user"], $config_db["password"], $config_db["database"]);
        $this->table = $config_db["table"];

        session_start();
        if (isset($_SESSION["UserID"]) && isset($_SESSION["Password"])) {
            $user_model = new User($_SESSION["UserID"], $_SESSION["Password"], false);
            $this->user_data = $user_model->getData();
        } else {
            $this->user_data = null;
        }
    }

    public function logPaging() {
        $userIP = $this->mysqli->escape_string($_SERVER["REMOTE_ADDR"]);
        $userNumber = ($this->user_data !== null) ? $this->user_data["UserNumber"] : "NULL";
        $url = $this->mysqli->escape_string("{$_SERVER["HTTP_HOST"]}{$_SERVER["REQUEST_URI"]}");
        $browser = get_browser(null, true)["parent"];

        $sql = "
            INSERT INTO {$this->table["log_paging"]} (UserIP, UserNumber, URL, Browser)
            VALUES ('{$userIP}', {$userNumber}, '{$url}', '{$browser}')";
        
        $this->mysqli->query($sql);
    }
}
?>
