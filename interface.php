<?php
echo "<title>Home Page</title>";
echo "<h1>Home Page</h1>";
echo "<hr />";
session_start();
//css part
echo "<style>";
include ('fieldset.css');
echo "</style>";
echo "<link href='https://fonts.googleapis.com/css?family=Pangolin' rel='stylesheet'>";
//create a new CSRF token.
$_SESSION['token'] = bin2hex(openssl_random_pseudo_bytes(32));
$token=$_SESSION['token'];
require 'database.php';
$stmt = $mysqli->prepare("select story.author, story.title, content, link from story");
if(!$stmt){
	printf("Query Prep Failed: %s\n", $mysqli->error);
	exit;
}
 
$stmt->execute();
 
$stmt->bind_result($author, $title, $content, $link);

//search portion
 echo "<form action='search.php' method='POST'>";
 echo "<p>What are you looking for?</p>";
 echo "<select name='fields'>";
 echo "<option value = 'author'>author</option>";
 echo "<option value = 'title'>title</option>";
 echo "<option value = 'content'>content</option>";
 echo "</select>";
 echo "<input type='hidden' name='token' value=$token />";
 echo "<input type='text' name='search' />";
 echo "<input type='submit' value='search'></form>";
        

// Escape Output
$author=htmlentities($author);
$title=htmlentities($title);
$content=htmlentities($content);
//List all the stories below
while($stmt->fetch()){
    echo "<form action = 'comment.php' method = 'post'>";

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
        
        echo "<input type='hidden' name='author' value= '$author'/>";
        echo "<input type='hidden' name='title' value='$title' />";
		echo "<p><input type='hidden' name='token' value=$token /></p>";
        echo "<p><input type = 'submit' value = 'comments' /> </p>";
echo "</form>";
// Save the article to the user's center.
if(isset($_SESSION['username'])){
		echo "<form action ='insertsave.php' method ='POST'>";
	    echo "<input type='hidden' name='author' value= '$author'/>";
		echo "<input type='hidden' name='title' value='$title' />";
		echo "<input type='hidden' name='link' value='$link' />";
		echo "<input type='hidden' name='content' value='$content' />";
		echo "<p><input type='hidden' name='token' value=$token /></p>";
		echo "<input type = 'submit' value = 'save' />";
		echo "<hr />";
        echo "<br />";
        echo "<br />";
		echo "</form>";
    }
	}
    if(isset($_SESSION['username'])){
       echo "<p><a href = 'personalcenter.php'><button type='button'>Personal Center</button></a></p>";
       echo "<p><a href='logout.php' ><button type='button' >Log out</button></a></p>";
    }
$stmt->close();




?>