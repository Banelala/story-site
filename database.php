<?php
$mysqli = new mysqli('localhost', 'editor', 'phpuse', 'site');
 
if($mysqli->connect_errno) {
	printf("Connection Failed: %s\n", $mysqli->connect_error);
	exit;
}
?>