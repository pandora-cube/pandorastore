<?php
require_once("models/user.php");

class Reviews {
    private $mysqli;
    private $table;
    private $data;
    private $isPCubeMember;
    private $adminLevel;
    private $userNumber;
    private $userIP;

    public function __construct($content = null) {
        $config_db = parse_ini_file("configs/database.ini");

        // DB 접속
        $this->mysqli = mysqli_connect($config_db["host"], $config_db["user"], $config_db["password"], $config_db["database"]);
        $this->table = $config_db["table"];

        // 유저데이터 로드
        session_start();
        $user_data = null;
        if (isset($_SESSION["UserID"]) && isset($_SESSION["Password"])) {
            $user_model = new User($_SESSION["UserID"], $_SESSION["Password"], false);
            $user_data = $user_model->getData();
        }
        $this->isPCubeMember = ($user_data["PCubeMember"] == 1); // 판도라큐브 회원 여부
        $this->adminLevel = $user_data["AdminLevel"];
        $this->userNumber = ($user_data !== null) ? $user_data["UserNumber"] : "NULL"; // 유저 번호
        $this->userIP = $this->mysqli->escape_string($_SERVER["REMOTE_ADDR"]); // 유저 아이피

        if ($this->mysqli && $content !== null)
            $this->load($content);
    }

    public function load($content) {
        $content = $this->mysqli->escape_string($content); // 콘텐츠 식별자

        // 리뷰 데이터와 작성자 닉네임 로드
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
            while ($datum = $result->fetch_assoc()) {
                $datum["DeletePermission"] = ($this->adminLevel >= 1 || $this->userNumber === $datum["UserNumber"]);

                array_push($this->data, $datum);
            }
            $result->free();
        }
        return $this->data;
    }

    public function write($content, $result) {
        // 판도라큐브 회원인 경우에만 작성 가능
        if (!$this->isPCubeMember)
            return false;

        $content = $this->mysqli->escape_string($content); // 콘텐츠 식별자
        $result = $this->mysqli->escape_string($result); // 리뷰 내용

        $sql = "
            INSERT INTO {$this->table["reviews"]}
                (Content, UserNumber, UserIP, Result)
            VALUES
                ('{$content}', {$this->userNumber}, '{$this->userIP}', '{$result}')";
        $this->mysqli->query($sql);
    }

    public function edit($reviewID, $result) {
        $reviewID = $this->mysqli->escape_string($reviewID); // 리뷰 번호
        $result = $this->mysqli->escape_string($result); // 리뷰 내용

        $sql = "
            UPDATE {$this->table["reviews"]} SET
                UserIP = '{$this->userIP}',
                Result = '{$result}',
                EditedTime = CURRENT_TIMESTAMP
            WHERE ID = {$reviewID}";
        $this->mysqli->query($sql);
    }

    public function delete($reviewID) {
        // 관리자, 작성자만 삭제 가능
        $conWriter = "";
        if ($this->adminLevel < 1)
            $conWriter = "AND UserNumber = {$this->userNumber}";

        $reviewID = $this->mysqli->escape_string($reviewID); // 리뷰 번호

        $sql = "
            UPDATE {$this->table["reviews"]} SET
                Deleted = 1
            WHERE ID = {$reviewID} {$conWriter}";
        $this->mysqli->query($sql);
    }

    public function getData() {
        return $this->data;
    }
}
?>
