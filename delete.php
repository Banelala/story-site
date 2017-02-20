<?php
require 'database.php';
 session_start();
 if(!isset($_SESSION['username'])){
	header("Location: login.html");
    exit;
}
//get the authorname, title, content, link of a single piece of story.
$title = $_POST['title'];
$username=$_SESSION['username'];
$title=htmlentities($title);
//Insert into the table story.
$stmt = $mysqli->prepare("delete from story where author=? and title=?");
$stmt1 = $mysqli->prepare("delete from comment where author=? and title=?");
$stmt2 = $mysqli->prepare("delete from usersaved where author=? and title=?");
if(!$stmt){
	printf("Query Prep Failed: %s\n", $mysqli->error);
	exit;
}
if(!$stmt1){
	printf("Query Prep Failed: %s\n", $mysqli->error);
	exit;
}

if(!$stmt2){
	printf("Query Prep Failed: %s\n", $mysqli->error);
	exit;
}
$stmt->bind_param('ss', $username,$title);
$stmt1->bind_param('ss', $username,$title);
$stmt2->bind_param('ss', $username,$title);
$stmt2->execute();
$stmt1->execute();
$stmt->execute();
$stmt->close();
$stmt1->close();
$stmt2->close();
header("Location: interface.php");
?>