<?php
require_once("models/users.php");

$name = $_POST["name"];

$conditions = [
    ["Name", "=", $name],
    ["Name", "<>", ""],
    ["Authenticated", "=", 1],
];

$users_model = new Users();
$users_data = $users_model->load($conditions, "CreatedTime DESC");
$creator_data = [
    UserNumber => $users_data[0]["UserNumber"],
    Name => $users_data[0]["Name"],
];
print(json_encode($creator_data));
?>
