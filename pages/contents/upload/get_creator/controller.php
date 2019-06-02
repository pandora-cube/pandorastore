<?php
require_once("models/users.php");

$name = $_POST["name"];
$equal = $_POST["equal"];

$nameCondition = [
    "OR",
    ["Name", "LIKE", "{$name}%"],
    ["Nickname", "LIKE", "{$name}%"],
];
if ($equal) {
    $nameCondition = [
        "OR",
        ["Name", "=", $name],
        ["Nickname", "=", $name],
    ];
}
$conditions = [
    "AND",
    $nameCondition,
    ["LENGTH(Name)", ">", 0],
    ["Authenticated", "=", 1],
];

$users_model = new Users();
$users_data = $users_model->load($conditions, "CreatedTime DESC");
$creator_data = array();
foreach ($users_data as $datum) {
    $map = [
        UserNumber => $datum["UserNumber"],
        Nickname => $datum["Nickname"],
        Name => $datum["Name"],
    ];
    array_push($creator_data, $map);
}
print(json_encode($creator_data));
?>
