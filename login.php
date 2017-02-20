<?php
session_start();


$_SESSION['username']= $_POST['username'];
$username=$_SESSION['username'];
$password = $_POST['password'];
require 'database.php';
 if(!isset($_SESSION['username'])){
	header("Location: login.html");
    exit;
}
// Use a prepared statement
$stmt = $mysqli->prepare("SELECT password FROM login WHERE username=?");
// Bind the parameter
$stmt->bind_param('s', $username);
$stmt->execute();
// Bind the results
$stmt->bind_result($pwd_hash);
$stmt->fetch();
// Compare the submitted password to the actual password hash
// In PHP < 5.5, use the insecure: if( $cnt == 1 && crypt($pwd_guess, $pwd_hash)==$pwd_hash){
 
if( password_verify($password, $pwd_hash)){
	// Login succeeded!   
	$_SESSION['username'] = $_POST['username'];
    header("Location: interface.php");
	// Redirect to your target page
} else{
    echo "failed to login!";
    echo "<p><a href='login.html' ><button type='button' >Back</button></a></p>";
	// Login failed; redirect back to the login screen
}
$stmt->close();
?>