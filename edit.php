<?php
session_start();
if(!isset($_SESSION['username'])){
	header("Location: login.html");
}
// create a CSRF token
$_SESSION['token'] = bin2hex(openssl_random_pseudo_bytes(32));
$token = $_SESSION['token'] ;
require 'database.php';
$title = $_POST['title'];
$content = $_POST['content'];


$_SESSION['originaltitle'] = $title;
$title = htmlentities($title);
$username =$_SESSION['username'];
$stmt = $mysqli->prepare("select content, link from story where title='$title' and author= '$username'");
if(!$stmt){
	printf("Query Prep Failed: %s\n", $mysqli->error);
	exit;
}
 
$stmt->execute();
 
$stmt->bind_result($content, $link);
$content = htmlentities($content);
$link = htmlentities($link);
$stmt->fetch();

echo "<form action= 'editsuccess.php' method='POST'>";
// transfer the title, content,link,token to the next page so the story can be editted.
echo "<p>Your story title: $title</p>";
echo "<p>Your Story:</p>";
echo "<p><textarea name='content' cols='50' rows='20' />$content</textarea></p>";
echo "<p>Your story link: <input type='text' name= 'link' value='$link' /></p>";
echo "<p><input type='hidden' name='title' value='$title' /></p>";
echo "<p><input type='hidden' name='token' value=$token /></p>";
echo "<p><input type= 'submit' value='Edit' /></p>";
echo "</form>";
$stmt->close();

?>