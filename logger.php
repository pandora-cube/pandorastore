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

    public function __construct($link, $table) {
        $this->mysqli = $link;
        $this->table = $table;

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

        $sql = "
            INSERT INTO {$this->table["log_paging"]} (UserIP, UserNumber, URL)
            VALUES (\"{$userIP}\", {$userNumber}, \"{$url}\")";
        
        $this->mysqli->query($sql);
    }
}
?>
