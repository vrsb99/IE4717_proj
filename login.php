<?php //authmain.php
include "dbconnect.php";
session_start();

if (isset($_POST['submit'])) {
	if (empty($_POST['username']) || empty ($_POST['password'])
		|| empty ($_POST['password2']) ) {
	echo "All records to be filled in";
	exit;}
}

if (isset($_POST['email']) && isset($_POST['password']))
{
  // if the user has just tried to log in
  $email= $_POST['email'];
  $password = $_POST['password'];
/*
  $db_conn = new mysqli('localhost', 'webauth', 'webauth', 'auth');

  if (mysqli_connect_errno()) {
   echo 'Connection to database failed:'.mysqli_connect_error();
   exit();
  }
*/
$password = md5($password);
$query = 'select * from users '
          ."where email='$email' "
          ." and password='$password'";
// echo "<br>" .$query. "<br>";

  $result = $db->query($query);
  if ($result->num_rows > 0 )
  {
    // if they are in the database register the user id
    $_SESSION['valid_user'] = $email;    
    echo $script;
    
    $script = '<script>alert("You are successfully logged in ! Browse our website and order your favourite food now !"); window.location.href = "index.html";</script>';
    echo $script;
    
  }

  else {
    $script = '<script>alert("You are not yet registered as our member. Register now using the sign up link below !"); window.location.href = "login.php";</script>';
    echo $script;
  }
  $db->close();
}
?>
