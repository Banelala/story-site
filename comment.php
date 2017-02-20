<?php
echo "<title>Comment</title>";
session_start();
// pass the CSRF token.
if(!hash_equals($_SESSION['token'], $_POST['token'])){
	die("Request forgery detected");
}
//css part
echo "<style>";
include ('fieldset.css');
echo "</style>";
echo "<link href='https://fonts.googleapis.com/css?family=Pangolin' rel='stylesheet'>";
// create a new CSRF token.
$_SESSION['token'] = bin2hex(openssl_random_pseudo_bytes(32));
$token=$_SESSION['token'];
require 'database.php';
$author=$_POST['author'];
$title=$_POST['title'];
$title = htmlentities($title);
$author = htmlentities($author);
$stmt = $mysqli->prepare("select username, comment from comment where author = '$author' and title = '$title'");
if(!$stmt){
	printf("Query Prep Failed: %s\n", $mysqli->error);
	exit;
}
 
$stmt->execute();
 
$stmt->bind_result($username, $comment);

$comment=htmlentities($comment);


//create a field to show the comments and the corresponding commentator(username).
while($stmt->fetch()){
	if($username == $_SESSION['username']){
 echo "<form action = 'editcomment.php' method = 'post'>";

        echo "<fieldset>";
        echo "<legend>By $username</legend>";
        echo "<p>Comment: $comment</p>";
        echo "</fieldset>";
		 echo "<input type= 'hidden' name='title' value='$title' />";
        echo "<input type= 'hidden' name='author' value='$author' />";
        echo "<input type= 'hidden' name='comment' value='$comment' />";
		echo "<p><input type='submit' value='edit' /></p>";
		echo "</form>";
	}
	else{
		 echo "<fieldset>";
        echo "<legend>By $username</legend>";
        echo "<p>Comment: $comment</p>";
        echo "</fieldset>";}
        echo "<br />";
	}
	

//First determine whether it's a registered user or an unregistered user, if registered, then he can comment.
if(isset($_SESSION['username'])){
echo "<form action = 'insertcomment.php' method = 'post'>";
echo "<p>Your comment: <input type = 'text' name = 'comment' /></p>";
echo "<input type ='hidden' name='author' value='$author' />";
echo "<input type ='hidden' name='title' value='$title'/>";
echo "<p><input type='hidden' name='token' value=$token /></p>";
echo "<input type = 'submit' value ='submit' />";
echo "</form>";
}
echo "<a href='interface.php' ><button type='button' >Back</button></a>";

?>