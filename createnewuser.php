<?php

session_start();
require 'database.php';
$_SESSION['username'] = $_POST['username'];
$username=$_SESSION['username'];
if(!isset($_SESSION['username'])){
	header("Location: login.html");
    exit;
}
$_SESSION['token'] = bin2hex(openssl_random_pseudo_bytes(32));
// Get the username and make sure that it is alphanumeric with limited other characters.
// You shouldn't allow usernames with unusual characters anyway, but it's always best to perform a sanity check
// since we will be concatenating the string to load files from the filesystem.

if( !preg_match('/^[\w_\-]+$/', $username) ){
	echo "Invalid username";
	exit;
}
// Verify that the passwords are the same.
$passworda = (String)$_POST['passworda'];
$passwordb = password_hash((String)$_POST['passwordb'], PASSWORD_DEFAULT);
if(password_verify($passworda,$passwordb)){
    require 'database.php';
    $stmt = $mysqli->prepare("insert into login(username, password) values (?, ?)");
     if(!$stmt){
	    printf("Query Prep Failed: %s\n", $mysqli->error);
	    exit;
     }
     $stmt->bind_param('ss', $username, $passwordb);
     if(!$stmt->execute()){
         echo "The username already exists!";
		  echo "<p><a href='signup.html' ><button type='button' >Back</button></a></p>";
		  exit;
     }
     $stmt->close();
     header("Location: interface.php");
}
else{
    echo"You entered different passwords, please try again!";
}

?>