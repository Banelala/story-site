<?php
echo "<title>Personal Center</title>";
session_start();
//create a new CSRF token when a story is written.
$_SESSION['token'] = bin2hex(openssl_random_pseudo_bytes(32));
//css part
echo "<style>";
include ('fieldset.css');
echo "</style>";
echo "<link href='https://fonts.googleapis.com/css?family=Pangolin' rel='stylesheet'>";
$token=$_SESSION['token'] ;
$username = $_SESSION['username'];
require 'database.php';
if(!isset($_SESSION['username'])){
	header("Location: login.html");
} 
$stmt = $mysqli->prepare("select title, content, link from story where author= '$username'");
if(!$stmt){
	printf("Query Prep Failed: %s\n", $mysqli->error);
	exit;
}
 
$stmt->execute();
 
$stmt->bind_result($title, $content,$link);

//List the stories below.
echo "<p>Here are your stories:</p>";

while($stmt->fetch()){

        echo "<form>";
        echo "<fieldset>";
		if($link == ''){
              echo "<legend>$title</legend>";
        }
        else{
        echo "<legend><a href='$link'>$title</a></legend>";
        }
        echo "<p>Content: $content</p>";
        echo "</fieldset>";
        echo "</form>";
        echo "<form action= 'edit.php' method = 'POST'>";
        echo "<input type= 'hidden' name='title' value='$title' />";
        echo "<input type= 'hidden' name='content' value='$content' />";
        echo "<input type= 'submit' value='edit' />";
        echo "</form>";
        echo "<form action= 'delete.php' method = 'POST'>";
        echo "<input type= 'hidden' name='title' value='$title' />";
        echo "<input type= 'submit' value='delete' />";
        echo "</form>";
        echo "<hr />";
        echo "<br />";
}
//Write your story;

echo "<form action ='insertstory.php' method = 'POST' >";
echo "<p>Your story title: <input type= 'text' name='title' /></p>";
echo "<p>Your Story:</p>";
echo "<p><textarea name='content' cols='50' rows='20' placeholder='Enter your story here' /></textarea></p>";
echo "<p>Your story link: <input type='text' name= 'link' /></p>";
echo "<p><input type='hidden' name='token' value=$token /></p>";
echo "<p><input type= 'submit' value='Create a new story' /></p>";
echo "<hr />";
echo "<br />";
 



$stmt1 = $mysqli->prepare("select author, title, comment from comment where username= '$username'");
if(!$stmt1){
	printf("Query Prep Failed: %s\n", $mysqli->error);
	exit;
}
 
$stmt1->execute();
 
$stmt1->bind_result($author, $title, $comment);

//Escape output.
$author = htmlentities($author);
$title = htmlentities($title);
$comment = htmlentities($comment);

//list the comments below.
echo "<p>Here are your comments:</p>";
while($stmt1->fetch()){
        echo "<form>";
        echo "<fieldset>";
        echo "<legend>$title</legend>";
        echo "<p>Comment: $comment</p>";
        echo "</fieldset>";
        echo "</form>";
        echo "<form action= 'editcomment.php' method = 'POST'>";
        echo "<input type= 'hidden' name='title' value='$title' />";
        echo "<input type= 'hidden' name='author' value='$author' />";
        echo "<input type= 'hidden' name='comment' value='$comment' />";
        echo "<input type= 'submit' value='edit' />";
        echo "</form>";
        echo "<form action= 'deletecomment.php' method = 'POST'>";
        echo "<input type= 'hidden' name='title' value='$title' />";
        echo "<input type= 'hidden' name='author' value='$author' />";
        echo "<input type= 'hidden' name='comment' value='$comment' />";
        echo "<input type= 'submit' value='delete' />";
        echo "</form>";
        echo "<hr />";
        echo "<br />";
        echo "<br />";
	}
	echo "<p><a href='save.php' ><button type='button' >Saved stories</button></a></p>";
    echo "<p><a href='interface.php' ><button type='button' >Back</button></a></p>";
    echo "<p><a href='logout.php' ><button type='button' >Log out</button></a></p>";
        $stmt->close();   
        $stmt1->close(); 
        
?>