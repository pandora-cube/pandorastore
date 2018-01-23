<?php
class User {
    private $mysqli;
    private $table;
    private $data;

    public function __construct($link, $table) {
        $this->mysqli = $link;
        $this->table = $table;
    }

    public function load($userID, $password, $encrypt) {
        $userID = $this->mysqli->escape_string($userID);
        $password = $this->mysqli->escape_string($password);

        $con_password = ($encrypt) ? "Password = SHA1(\"{$password}\")" : "Password = \"{$password}\"";

        $sql = "
            SELECT *
            FROM {$this->table["users"]}
            WHERE UserID = \"{$userID}\" AND {$con_password}";

        $this->data = null;
        if ($result = $this->mysqli->query($sql)) {
            if ($result->num_rows > 0)
                $this->data = $result->fetch_assoc();
            $result->free();
        }
        return $this->data;
    }

    public function request($inputData, $authCode) {
        $nickname = $this->mysqli->escape_string($inputData["Nickname"]);
        $userID = $this->mysqli->escape_string($inputData["UserID"]);
        $password = $this->mysqli->escape_string($inputData["Password"]);

        // 중복 계정 확인
        $sql = "
            SELECT UserNumber, Authenticated
            FROM {$this->table["users"]}
            WHERE UserID = '{$userID}'
            ORDER BY CreatedTime DESC";
        $result = $this->mysqli->query($sql);

        // 중복 계정이 존재하는 경우
        if ($result->num_rows > 0) {
            $userData = $result->fetch_row();

            // 중복 계정이 인증까지 완료된 계정인 경우
            if ($userData[1] == 1)
                return;

            // 중복 계정의 정보 업데이트
            $sql = "
                UPDATE {$this->table["users"]} SET
                    Nickname = '{$nickname}',
                    Password = SHA1('{$password}'),
                    AuthCode = '{$authCode}'
                WHERE UserNumber = {$userData[0]}";
            $this->mysqli->query($sql);
            return;
        }

        // 계정 요청
        $sql = "
            INSERT INTO {$this->table["users"]}
                (Nickname, UserID, Email, Password, AuthCode)
            VALUES
                ('{$nickname}', '{$userID}', '{$userID}', SHA1('{$password}'), '{$authCode}')";
        $this->mysqli->query($sql);
    }
}
?>
