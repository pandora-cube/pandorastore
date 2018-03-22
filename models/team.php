<?php
require_once("models/user.php");

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

        $this->data = [];
        if ($result = $this->mysqli->query($sql)) {
            while ($datum = $result->fetch_assoc()) {
                $datum["MembersList"] = $this->parseMembers($datum["Members"]);
                array_push($this->data, $datum);
            }
            $result->free();
        }
        return $this->data;
    }

    public function getData() {
        return $this->data;
    }

    private function parseMembers($members_) {
        $members = json_decode("[{$members_}]");

        $result = "";
        foreach ($members as $member) {
            $type = gettype($member);

            if ($type === "integer") {
                $user_model = new User($member, null, null, true);
                $user_data = $user_model->getData();

                if ($user_data["PCubeMember"] === 1) { // 판도라큐브 회원인 경우
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
