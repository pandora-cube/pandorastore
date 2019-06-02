<?php
require_once("models/users.php");

class Team {
    private $mysqli;
    private $table;
    private $data;

    public function __construct($teamID) {
        $config_db = parse_ini_file("configs/database.ini");

        $this->mysqli = mysqli_connect($config_db["host"], $config_db["user"], $config_db["password"], $config_db["database"]);
        $this->table = $config_db["table"];

        if ($this->mysqli)
            $this->load($teamID);
    }

    public function load($teamID) {
        $teamID = intval($teamID);

        $sql = "
            SELECT *
            FROM {$this->table["teams"]}
            WHERE ID = {$teamID}";

        $this->data = null;
        if ($result = $this->mysqli->query($sql)) {
            if ($result->num_rows > 0) {
                $this->data = $result->fetch_assoc();
                $this->data["MembersList"] = $this->parseMembers($this->data["Members"]);
            }
            $result->free();
        }
        return $this->data;
    }

    public function getData() {
        return $this->data;
    }

    public function insert($teamName, $members) {
        $teamName = $this->mysqli->escape_string($teamName);

        $membersText = "";
        foreach ($members as $memberID) {
            $membersText .= "{$memberID},";
        }
        $membersText = substr($membersText, 0, strlen($membersText)-1);

        $sql = "
            INSERT INTO {$this->table["teams"]}
                (Name, Members)
            VALUES
                ('{$teamName}', '$membersText')";
        $this->mysqli->query($sql);

        return $this->mysqli->insert_id;
    }

    private function parseMembers($members_) {
        $members = json_decode("[{$members_}]");

        $result = "";
        foreach ($members as $member) {
            $type = gettype($member);

            if ($type === "integer") {
                $users_model = new Users(["UserNumber", "=", $member]);
                $user_data = $users_model->getData()[0];

                if ($user_data["PCubeMember"] == 1) { // 판도라큐브 회원인 경우
                    if ($user_data["Name"] === $user_data["Nickname"]) { // 성명과 닉네임이 같은 경우
                        $result .= "{$user_data["Name"]}"; // 성명
                    } else {
                        $result .= "{$user_data["Name"]}({$user_data["Nickname"]})"; // 성명(닉네임)
                    }
                } else {
                    $result .= "{$user_data["Nickname"]}";
                }
            } else if ($type === "string") {
                $result .= "{$member}"; // 성명
            }

            $result .= ", ";
        }

        return substr($result, 0, -2);
    }
}
?>
