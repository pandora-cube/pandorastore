<?php
require_once("models/user.php");

class Reviews {
    private $mysqli;
    private $table;
    private $data;
    private $isPCubeMember;
    private $userNumber;
    private $userIP;

    public function __construct($content = null) {
        $config_db = parse_ini_file("configs/database.ini");

        $this->mysqli = mysqli_connect($config_db["host"], $config_db["user"], $config_db["password"], $config_db["database"]);
        $this->table = $config_db["table"];

        session_start();
        $user_data = null;
        if (isset($_SESSION["UserID"]) && isset($_SESSION["Password"])) {
            $user_model = new User($_SESSION["UserID"], $_SESSION["Password"], false);
            $user_data = $user_model->getData();
        }
        $this->isPCubeMember = ($user_data["PCubeMember"] == 1);
        $this->userNumber = ($user_data !== null) ? $user_data["UserNumber"] : "NULL";
        $this->userIP = $this->mysqli->escape_string($_SERVER["REMOTE_ADDR"]);

        if ($this->mysqli && $content !== null)
            $this->load($content);
    }

    public function load($content) {
        $content = $this->mysqli->escape_string($content);

        $sql = "
            SELECT
                a.*,
                b.Nickname AS UserNickname
            FROM {$this->table["reviews"]} a
            LEFT JOIN {$this->table["users"]} b
                ON a.UserNumber = b.UserNumber
            WHERE a.Content = '{$content}' AND a.Deleted = 0
            ORDER BY a.WritedTime DESC";

        $this->data = [];
        if ($result = $this->mysqli->query($sql)) {
            while ($datum = $result->fetch_assoc())
                array_push($this->data, $datum);
            $result->free();
        }
        return $this->data;
    }

    public function write($content, $result) {
        if (!$this->isPCubeMember)
            return false;

        $content = $this->mysqli->escape_string($content);
        $result = $this->mysqli->escape_string($result);

        $sql = "
            INSERT INTO {$this->table["reviews"]}
                (Content, UserNumber, UserIP, Result)
            VALUES
                ('{$content}', {$this->userNumber}, '{$this->userIP}', '{$result}')";
        $this->mysqli->query($sql);
    }

    public function edit($reviewID, $result) {
        $reviewID = $this->mysqli->escape_string($reviewID);
        $result = $this->mysqli->escape_string($result);

        $sql = "
            UPDATE {$this->table["reviews"]} SET
                UserIP = '{$this->userIP}',
                Result = '{$result}',
                EditedTime = CURRENT_TIMESTAMP
            WHERE ID = {$reviewID}";
        $this->mysqli->query($sql);
    }

    public function delete($reviewID) {
        $reviewID = $this->mysqli->escape_string($reviewID);

        $sql = "
            UPDATE {$this->table["reviews"]} SET
                Deleted = 1
            WHERE ID = {$reviewID}";
        $this->mysqli->query($sql);
    }

    public function getData() {
        return $this->data;
    }
}
?>
