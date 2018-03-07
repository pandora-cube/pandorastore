<?php
require_once("models/user.php");

class Messages {
    private $mysqli;
    private $table;
    private $data;
    private $userNumber;
    private $userIP;

    public function __construct() {
        $config_db = parse_ini_file("configs/database.ini");

        // DB 접속
        $this->mysqli = mysqli_connect($config_db["host"], $config_db["user"], $config_db["password"], $config_db["database"]);
        $this->table = $config_db["table"];

        // 유저데이터 로드
        $user_model = new User();
        $user_data = $user_model->getData();
        $this->userNumber = (isset($user_data)) ? $user_data["UserNumber"] : "NULL";
        $this->userIP = $this->mysqli->escape_string($_SERVER["REMOTE_ADDR"]);
    }

    public function load($receiverNumber, $onlyUnread) {
        $receiverNumber = (isset($receiverNumber)) ? intval($receiverNumber) : $this->userNumber;
        $conRead = ($onlyUnread) ? "a.Read = 0" : "TRUE";

        $sql = "
            SELECT
                a.*,
                b.Nickname AS SenderNickname
            FROM {$this->table["messages"]} a
            LEFT JOIN {$this->table["users"]} b
                ON a.SenderNumber = b.UserNumber
            WHERE a.ReceiverNumber = {$receiverNumber} AND {$conRead} AND a.Deleted = 0
            ORDER BY a.SendedTime DESC";

        $this->data = [];
        if ($result = $this->mysqli->query($sql)) {
            while ($datum = $result->fetch_assoc())
                array_push($this->data, $datum);
            $result->free();
        }
        return $this->data;
    }

    public function send($receiverNumber, $subject, $result, $replyEnabled = true) {
        $receiverNumber = intval($receiverNumber);
        $subject = $this->mysqli->escape_string($subject);
        $result = $this->mysqli->escape_string($result);
        $replyEnabled = intval($replyEnabled);

        $sql = "
            INSERT INTO {$this->table["messages"]}
                (SenderNumber, SenderIP, ReceiverNumber, Subject, Result, ReplyEnabled)
            VALUES
                ({$this->userNumber}, '{$this->userIP}', '{$receiverNumber}', '{$subject}', '{$result}', {$replyEnabled})";
        $this->mysqli->query($sql);
    }

    public function getData() {
        return $this->data;
    }
}
?>
