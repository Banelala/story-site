<?php
session_start();

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
$stmt = $mysqli->prepare("select author, title, content, link from usersaved where username= '$username'");
if(!$stmt){
	printf("Query Prep Failed: %s\n", $mysqli->error);
	exit;
}
 
$stmt->execute();
 
$stmt->bind_result($author, $title, $content,$link);

echo "<p>Here are your saved stories:</p>";

while($stmt->fetch()){

        echo "<fieldset>";
		if($link == ''){
              echo "<legend>$title</legend>";
        }
        else{
        echo "<legend><a href='$link'>$title</a></legend>";
        }
        echo "<p>Author: $author</p>";
        echo "<p>Content: $content</p>";
        
        echo "</fieldset>";
        // delete the saved stories.
         echo "<form action ='deletesave.php' method = 'POST'>";
         echo "<p><input type='hidden' name='token' value=$token /></p>";
         echo "<input type ='hidden' name='author' value='$author' />";
         echo "<input type ='hidden' name='title' value='$title' />";
         echo "<input type='submit' value='delete' />";
        echo "</form>";
        echo "<hr />";
        echo "<br />";
}
    echo "<a href='interface.php'><button type='button'>Back</button></a>";
?>