<?php
require_once("models/user.php");

class Users {
    private $mysqli;
    private $table;
    private $data;

    public function __construct($conditions = []) {
        $config_db = parse_ini_file("configs/database.ini");

        $this->mysqli = mysqli_connect($config_db["host"], $config_db["user"], $config_db["password"], $config_db["database"]);
        $this->table = $config_db["table"];

        if ($this->mysqli)
            $this->load($conditions);
    }

    public function load($conditions) {
        $sql = "
            SELECT *
            FROM {$this->table["users"]}";
        
        if (count($conditions) > 0) {
            $sql .= " WHERE TRUE";
            foreach ($conditions as $condition) {
                $value = $this->mysqli->escape_string($condition[2]);
                $sql .= " AND ({$condition[0]} {$condition[1]} '{$value}')";
            }
        }
        
        $this->data = [];
        if ($result = $this->mysqli->query($sql)) {
            if ($result->num_rows > 0)
                array_push($this->data, $result->fetch_assoc());
            $result->free();
        }
        return $this->data;
    }

    public function getData() {
        return $this->data;
    }

    public function request($inputData, $authCode) {
        $nickname = $this->mysqli->escape_string($inputData["Nickname"]);
        $email = $this->mysqli->escape_string($inputData["EMail"]);
        $password = $this->mysqli->escape_string($inputData["Password"]);
        $pcubemember = ($inputData["PCubeMember"] === "on");
        $name = $this->mysqli->escape_string($inputData["LastName"].$inputData["FirstName"]);
        $university = $this->mysqli->escape_string($inputData["Univ"]);
        $studentID = intval($inputData["StudentID"]);
        $part = $this->mysqli->escape_string($inputData["Part"]);

        // 중복 계정 확인
        $sql = "
            SELECT UserNumber, Authenticated
            FROM {$this->table["users"]}
            WHERE EMail = '{$userID}' OR Nickname = '{$userID}'
            ORDER BY CreatedTime DESC";
        $result = $this->mysqli->query($sql);

        // 중복 계정이 존재하는 경우
        if ($result->num_rows > 0) {
            $userData = $result->fetch_row();

            // 중복 계정이 인증까지 완료된 계정인 경우
            if ($userData[1] == 1)
                return false;

            // 판도라큐브 회원 체크한 경우
            if ($pcubemember) {
                $sql_pcube = ",
                    PCubeMember = 2,
                    Name = '{$name}',
                    University = '{$university}',
                    StudentID = {$studentID},
                    PCubePart = '{$part}'
                    ";
            } else {
                $sql_pcube = ",
                    PCubeMember = 0";
            }

            // 중복 계정의 정보 업데이트
            $sql = "
                UPDATE {$this->table["users"]} SET
                    EMail = '{$email}',
                    Nickname = '{$nickname}',
                    Password = SHA1('{$password}'),
                    AuthCode = '{$authCode}'
                    {$sql_pcube}
                WHERE UserNumber = {$userData[0]}";
            $this->mysqli->query($sql);
            return true;
        }

        // 판도라큐브 회원 체크한 경우
        if ($pcubemember) {
            $col_pcube = ", PCubeMember, Name, University, StudentID, PCubePart";
            $val_pcube = ", 2, '{$name}', '{$university}', $studentID, '{$part}'";
        } else {
            $col_pcube = "";
            $val_pcube = "";
        }

        // 계정 요청
        $sql = "
            INSERT INTO {$this->table["users"]}
                (EMail, Nickname, Password, AuthCode {$col_pcube})
            VALUES
                ('{$email}', '{$nickname}', SHA1('{$password}'), '{$authCode}' {$val_pcube})";
        $this->mysqli->query($sql);
        return true;
    }
}
?>
