<?php
require 'database.php';
session_start();
//css part
echo "<style>";
include ('fieldset.css');
echo "</style>";
echo "<link href='https://fonts.googleapis.com/css?family=Pangolin' rel='stylesheet'>";
//examine the CSRF token.
if(!hash_equals($_SESSION['token'], $_POST['token'])){
	die("Request forgery detected");
}
//create a new CSRF token.
$_SESSION['token'] = bin2hex(openssl_random_pseudo_bytes(32));
$token=$_SESSION['token'];

// If the user search for author.
if($_POST['fields'] == 'author'){
    $author=$_POST['search'];
    $stmt = $mysqli->prepare("select story.author, story.title, content, link from story where author like '%$author%'");
if(!$stmt){
	printf("Query Prep Failed: %s\n", $mysqli->error);
	exit;
}
$stmt->execute();
 
$stmt->bind_result($author, $title, $content, $link);
// If there are no results, then it should redirect to the inferface page.
if($stmt->fetch()==false){
   echo "No results!";
   echo "<p><a href = 'interface.php'><button type='button' >Back</button></a></p>";
}
$stmt->execute();
 
$stmt->bind_result($author, $title, $content, $link);
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
        echo "<hr />";
        echo "<br />";
        echo "<br />";
echo "</form>";
    }
    }
    
    
//if the user searches for title.
    if($_POST['fields'] == 'title'){
$title=$_POST['search'];
    $stmt = $mysqli->prepare("select story.author, story.title, content, link from story where title like '%$title%'");
if(!$stmt){
	printf("Query Prep Failed: %s\n", $mysqli->error);
	exit;
}
 $stmt->execute();
 
$stmt->bind_result($author, $title, $content, $link);
// If there are no results, then it should redirect to the inferface page.
if($stmt->fetch()==false){
   echo "No results!";
   echo "<p><a href = 'interface.php'><button type='button' >Back</button></a></p>";
}
$stmt->execute();
 
$stmt->bind_result($author, $title, $content, $link);
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
        echo "<hr />";
        echo "<br />";
        echo "<br />";
echo "</form>";
    }  
    }

//if the user searches for content.
 if($_POST['fields'] == 'content'){
$content=$_POST['search'];
    $stmt = $mysqli->prepare("select story.author, story.title, content, link from story where content like '%$content%'");
if(!$stmt){
	printf("Query Prep Failed: %s\n", $mysqli->error);
	exit;
}
 $stmt->execute();
 
$stmt->bind_result($author, $title, $content, $link);
// If there are no results, then it should redirect to the inferface page.
if($stmt->fetch()==false){
   echo "No results!";
   echo "<p><a href = 'interface.php'><button type='button' >Back</button></a></p>";
}
$stmt->execute();
 
$stmt->bind_result($author, $title, $content, $link);
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
        echo "<hr />";
        echo "<br />";
        echo "<br />";
echo "</form>";
    }  
    }
        echo "<a href='interface.php'><button type='button'>Back to home page</button></a>";
?>