<?php
require_once("models/user.php");

class Reviews {
    private $mysqli;
    private $table;
    private $data;
    private $contentID;
    private $userNumber;
    private $userIP;

    public function __construct($contentID) {

        $config_db = parse_ini_file("configs/database.ini");

        $this->mysqli = mysqli_connect($config_db["host"], $config_db["user"], $config_db["password"], $config_db["database"]);
        $this->table = $config_db["table"];

        session_start();
        $user_data = null;
        if (isset($_SESSION["UserID"]) && isset($_SESSION["Password"])) {
            $user_model = new User($_SESSION["UserID"], $_SESSION["Password"], false);
            $user_data = $user_model->getData();
        }
        $this->contentID = $this->mysqli->escape_string($contentID);
        $this->userNumber = ($user_data !== null) ? $user_data["UserNumber"] : "NULL";
        $this->userIP = $this->mysqli->escape_string($_SERVER["REMOTE_ADDR"]);

        if ($this->mysqli)
            $this->load();
    }

    public function load() {
        $sql = "
            SELECT *
            FROM {$this->table["reviews"]}
            WHERE ContentID = {$this->contentID} AND Deleted = 0";

        $this->data = [];
        if ($result = $this->mysqli->query($sql)) {
            while ($datum = $result->fetch_assoc())
                array_push($this->data, $datum);
            $result->free();
        }
        return $this->data;
    }

    public function write($result) {
        $result = $this->mysqli->escape_string($result);

        $sql = "
            INSERT INTO {$this->table["reviews"]}
                (ContentID, UserNumber, UserIP, Result)
            VALUES
                ({$this->contentID}, {$this->userNumber}, '{$this->userIP}', '{$result}')";
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
