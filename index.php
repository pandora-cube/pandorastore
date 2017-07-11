<?php
$action = $_GET["action"];

loop:
if(is_file("views/$action.html")) {
	if(is_file("controllers/$action.php"))
		require("controllers/$action.php");
	require("views/$action.html");
} else {
	$action = "main";
	goto loop;
}
?>
