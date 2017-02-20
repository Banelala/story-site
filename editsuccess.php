<?php
session_start();

require 'database.php';
if(!isset($_SESSION['username'])){
	header("Location: login.html");
	exit;
}
//CSRF token is passed.
if(!hash_equals($_SESSION['token'], $_POST['token'])){
	die("Request forgery detected");
}
//get the authorname, title, content, link of a single piece of story.
$title = htmlentities($_POST['title']);
$originaltitle = htmlentities($_SESSION['originaltitle']);
$link = htmlentities($_POST['link']);
$content = htmlentities($_POST['content']);
$username=htmlentities($_SESSION['username']);

//Insert into the table story.
$stmt = $mysqli->prepare("update story set title=?, link=?, content=? where author=? and title=?");
if(!$stmt){
	printf("Query Prep Failed: %s\n", $mysqli->error);
	exit;
}

$stmt->bind_param('sssss', $title, $link, $content,$username,$originaltitle);
 
$stmt->execute();
 
$stmt->close();
header("Location: interface.php");
?>