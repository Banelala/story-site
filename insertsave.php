<?php
session_start();

require 'database.php';
//detect the CSRF token.
if(!hash_equals($_SESSION['token'], $_POST['token'])){
	die("Request forgery detected");
}
if(!isset($_SESSION['username'])){
	header("Location: login.html");
	exit;
} 
//get the authorname, title, content, link of a single piece of story.
$author = htmlentities($_POST['author']);
$title = htmlentities($_POST['title']);
$link = htmlentities($_POST['link']);
$content = htmlentities($_POST['content']);
//Insert into the table story.
$stmt = $mysqli->prepare("insert into usersaved (username,author, title, content, link ) values (?, ?, ?, ?, ?)");
if(!$stmt){
	printf("Query Prep Failed: %s\n", $mysqli->error);
	exit;
}

$stmt->bind_param('sssss', $_SESSION['username'], $author, $title, $content,$link);
 
$stmt->execute();
 
$stmt->close();
header("Location: save.php");
?>