<?php // register.php
include "dbconnect.php";

if (isset($_POST['submit'])) {
	if (empty($_POST['username']) || empty ($_POST['password'])
		|| empty ($_POST['password2']) ) {
	echo "All records to be filled in";
	exit;}
}

$username = $_POST['name'];
$email = strtolower($_POST['email']);
$password = $_POST['password'];
$password2 = $_POST['confirmPassword'];

// echo ("$username" . "<br />". "$password2" . "<br />");


$query = "SELECT * FROM users";
$result = $db->query($query);

while ($rows = $result ->fetch_assoc()) {
	if ($rows['email'] == $email){
		echo "<script> alert('You already have an account with Leafy Bites. Please login with your existing account.')</script>";
		echo '<script> location.href = "signup.html"</script> ';
		exit;
	}
}

if ($password != $password2) {
	echo "<script> alert('Passwords do not match. Please retry.')</script>";
	echo '<script> location.href = "signup.html"</script> ';
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
	$script = '<script>alert("Welcome ' . $username . '. You are now registered! You can now login to Leafy Bites with your details."); window.location.href = "login.html";</script>';
	echo $script;

	


?>