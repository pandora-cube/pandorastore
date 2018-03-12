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

    public function load($receiverNumber, $senderNumber) {
        $receiverNumber = (isset($receiverNumber)) ? intval($receiverNumber) : $this->userNumber;

        $sql =
            "SELECT
                a.*,
                b.Nickname AS SenderNickname
            FROM {$this->table["messages"]} a
            LEFT JOIN /* 발신자 닉네임 로드 */
                {$this->table["users"]} b
                ON a.SenderNumber = b.UserNumber
            WHERE
                a.SenderNumber = {$senderNumber}
                AND a.ReceiverNumber = {$receiverNumber}
                AND a.Deleted = 0
            ORDER BY a.SendedTime DESC";

        $this->data = [];
        if ($result = $this->mysqli->query($sql)) {
            while ($datum = $result->fetch_assoc())
                array_push($this->data, $datum);
            $result->free();
        }
        return $this->data;
    }

    public function loadRecents($receiverNumber) {
        $receiverNumber = (isset($receiverNumber)) ? intval($receiverNumber) : $this->userNumber;

        $sql =
            "SELECT
                a.*,
                c.Recents,
                d.Nickname AS SenderNickname
            FROM {$this->table["messages"]} a
            JOIN /* 발신자당 가장 최근의 1개 메시지만 로드 */
                (
                    SELECT MAX(SendedTime) AS RecentTime
                    FROM {$this->table["messages"]}
                    WHERE ReceiverNumber = {$receiverNumber} AND Deleted = 0
                    GROUP BY SenderNumber
                ) b
                ON a.SendedTime = b.RecentTime
            LEFT JOIN /* 해당 발신자의 메시지 중 읽지 않은 것 개수 */
                (
                    SELECT SenderNumber, COALESCE(SUM(`Read` = 0), 0) AS Recents
                    FROM {$this->table["messages"]}
                    WHERE ReceiverNumber = {$receiverNumber} AND Deleted = 0
                    GROUP BY SenderNumber
                ) c
                ON a.SenderNumber = c.SenderNumber
            LEFT JOIN /* 발신자 닉네임 로드 */
                {$this->table["users"]} d
                ON a.SenderNumber = d.UserNumber
            WHERE a.ReceiverNumber = {$receiverNumber} AND a.Deleted = 0
            ORDER BY a.SendedTime DESC";

        $this->data = [];
        if ($result = $this->mysqli->query($sql)) {
            while ($datum = $result->fetch_assoc())
                array_push($this->data, $datum);
            $result->free();
        }
        return $this->data;
    }

    public function send($receiverNumber, $result, $replyEnabled = true) {
        $receiverNumber = intval($receiverNumber);
        $result = $this->mysqli->escape_string($result);
        $replyEnabled = intval($replyEnabled);

        $sql = "
            INSERT INTO {$this->table["messages"]}
                (SenderNumber, SenderIP, ReceiverNumber, Result, ReplyEnabled)
            VALUES
                ({$this->userNumber}, '{$this->userIP}', '{$receiverNumber}', '{$result}', {$replyEnabled})";
        $this->mysqli->query($sql);
    }

    public function getData() {
        return $this->data;
    }
}
?>
