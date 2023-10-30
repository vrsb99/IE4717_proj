<?php // register.php
include "dbconnect.php";

if (isset($_POST['submit'])) {
	if (empty($_POST['username']) || empty ($_POST['password'])
		|| empty ($_POST['password2']) ) {
	echo "All records to be filled in";
	exit;}
}

$username = $_POST['name'];
$email = $_POST['email'];
$password = $_POST['password'];
$password2 = $_POST['confirmPassword'];

// echo ("$username" . "<br />". "$password2" . "<br />");
if ($password != $password2) {
	echo "<alert> Sorry passwords do not match";
	exit;
	}
$password = md5($password);
// echo $password;
$sql = "INSERT INTO users (username, email, password) 
		VALUES ('$username', '$email', '$password')";
//	echo "<br>". $sql. "<br>";
$result = $db->query($sql);

if (!$result) 
	echo "Your query failed.";
else
	$script = '<script>alert("Welcome ' . $username . '. You are now registered !"); window.location.href = "index.php";</script>';
	echo $script;
?>