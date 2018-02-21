<?php
require_once("models/user.php");

class Log {
    private $mysqli;
    private $table;
    private $data;
    private $userIP;
    private $userNumber;
    private $browser;
    private $platform;

    public function __construct() {
        $config_db = parse_ini_file("configs/database.ini");
        $browser = get_browser(null, true);

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
        $this->browser = $browser["parent"];
        $this->platform = $browser["platform"];
    }

    public function load($table, $conditions) {
        $sql = "
            SELECT *
            FROM {$this->table[$table]}";

        if (count($conditions) > 0) {
            $sql .= " WHERE TRUE";
            foreach ($conditions as $condition) {
                $value = $this->mysqli->escape_string($condition[2]);
                $sql .= " AND ({$condition[0]} {$condition[1]} '{$value}')";
            }
        }

        $sql .= " ORDER BY Time DESC";

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

        // 로그인 국가
        include_once("libraries/modules/GeoIP/geoip.inc");
        $geoip = geoip_open("libraries/modules/GeoIP/GeoIP.dat", GEOIP_STANDARD);
        $country = geoip_country_name_by_addr($geoip, $_SERVER["REMOTE_ADDR"]);

        $sql = "
            INSERT INTO {$this->table["log_signin"]} (UserNumber, UserIP, Success, Host, Browser, Platform, Country)
            VALUES ({$userNumber}, '{$this->userIP}', {$success}, '{$host}', '{$this->browser}', '{$this->platform}', '{$country}')";
        
        $this->mysqli->query($sql);
    }
}
?>
