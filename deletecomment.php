<?php
require 'database.php';
 session_start();
 if(!isset($_SESSION['username'])){
	header("Location: login.html");
    exit;
}
//get the authorname, title, content, link of a single piece of story.
$title = $_POST['title'];
$author=$_POST['author'];
$comment = $_POST['comment'];
$username=$_SESSION['username'];
$comment=htmlentities($comment);
$title=htmlentities($title);

//Delete a comment
$stmt1 = $mysqli->prepare("delete from comment where author=? and title=? and comment=?");
if(!$stmt1){
	printf("Query Prep Failed: %s\n", $mysqli->error);
	exit;
}

$stmt1->bind_param('sss', $author, $title, $comment);
$stmt1->execute();
$stmt1->close();
header("Location: interface.php");
?>