<?php
session_start();
//examine the CSRF token.
if(!hash_equals($_SESSION['token'], $_POST['token'])){
	die("Request forgery detected");
}
//create a new CSRF token.
$_SESSION['token'] = bin2hex(openssl_random_pseudo_bytes(32));
$token=$_SESSION['token']; 
require 'database.php';
if(!isset($_SESSION['username'])){
	header("Location: login.html");
} 
//get the authorname, title, content, link of a single piece of story.
$title = $_POST['title'];
$author = $_POST['author'];
$comment = $_POST['comment'];
//Escape output
$title = htmlentities($title);
$author = htmlentities($author);
$comment=htmlentities($comment);

$username = $_SESSION['username'];
//Insert into the table story.
$stmt = $mysqli->prepare("insert into comment (username, author, title, comment ) values (?, ?, ?, ?)");
if(!$stmt){
	printf("Query Prep Failed: %s\n", $mysqli->error);
	exit;
}

$stmt->bind_param('ssss', $_SESSION['username'], $author, $title,$comment);
 
$stmt->execute();
 
$stmt->close();
echo "Commented!";
echo "<form action = 'comment.php' method = 'post'>";
echo "<input type ='hidden' name='author' value='$author' />";
echo "<input type ='hidden' name='title' value='$title' />";
echo "<p><input type='hidden' name='token' value='$token' /></p>";
echo "<input type ='submit' value='Back to Comments' />";
echo "</form>";

?>