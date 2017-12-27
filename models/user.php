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
}
?>
