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
$title = $_POST['title'];
$author=$_POST['author'];
$comment = $_POST['comment'];
$username=$_SESSION['username'];
$originalcomment =$_SESSION['originalcomment'];

//Insert into the table story.
$stmt = $mysqli->prepare("update comment set comment=? where author=? and title=? and comment=?");
if(!$stmt){
	printf("Query Prep Failed: %s\n", $mysqli->error);
	exit;
}

$stmt->bind_param('ssss', $comment, $author, $title, $originalcomment);
 
$stmt->execute();
 
$stmt->close();
header("Location: interface.php");
?>