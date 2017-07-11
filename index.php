<?php
$action = $_GET["action"];

loop:
if(is_file("views/$action.html")) {
	if(is_file("controllers/$action.php"))
		require("controllers/$action.php");
	require("views/$action.html");
} else if(strlen($action) == 0) {
	$action = "main";
	goto loop;
} else {
	header("Location: http://".$_SERVER["SERVER_NAME"]);
	exit();
}
?>
