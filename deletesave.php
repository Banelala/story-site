<?php

require 'database.php';
 session_start();
 if(!isset($_SESSION['username'])){
	header("Location: login.html");
    exit;
}
//detect the CSRF token.
if(!hash_equals($_SESSION['token'], $_POST['token'])){
	die("Request forgery detected");
}
//get the authorname, title, content, link of a single piece of story.
$title = $_POST['title'];
$author=$_POST['author'];

$username=$_SESSION['username'];

$title=htmlentities($title);

//Delete the saved story.
$stmt1 = $mysqli->prepare("delete from usersaved where author=? and title=? and username=?");
if(!$stmt1){
	printf("Query Prep Failed: %s\n", $mysqli->error);
	exit;
}

$stmt1->bind_param('sss', $author, $title, $username);
$stmt1->execute();
$stmt1->close();
header("Location: save.php");
?>