<?php
echo "<title>Edit Comment</title>";
session_start();
//create a CSRF token.
$_SESSION['token'] = bin2hex(openssl_random_pseudo_bytes(32));
$token = $_SESSION['token'];
if(!isset($_SESSION['username'])){
	header("Location: login.html");
}
require 'database.php';
$title = $_POST['title'];
$content = $_POST['content'];
$comment=$_POST['comment'];
$author=$_POST['author'];
$username =$_SESSION['username'];
$_SESSION['originalcomment'] = $comment;


$stmt = $mysqli->prepare("select author, title, comment from comment where title='$title' and username= '$username' and author='$author'");
if(!$stmt){
	printf("Query Prep Failed: %s\n", $mysqli->error);
	exit;
}
 
$stmt->execute();
 
$stmt->bind_result($content, $link);

$stmt->fetch();

echo "<form action= 'editcommentsuccess.php' method='POST'>";

echo "<p>Your story title: $title</p>";
echo "<p><textarea name='comment' cols='50' rows='20'  />$comment</textarea></p>";
echo "<p><input type='hidden' name='author' value='$author' /></p>";
echo "<p><input type='hidden' name='title' value='$title' /></p>";
echo "<p><input type='hidden' name='token' value=$token /></p>";
echo "<p><input type= 'submit' value='Edit' /></p>";
echo "</form>";
$stmt->close();
?>