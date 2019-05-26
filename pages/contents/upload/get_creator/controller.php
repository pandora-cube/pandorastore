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
$creator_data = array();
foreach ($users_data as $datum) {
    $map = [
        UserNumber => $datum["UserNumber"],
        Name => $datum["Name"],
    ];
    array_push($creator_data, $map);
}
print(json_encode($creator_data));
?>
