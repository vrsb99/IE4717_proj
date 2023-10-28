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
  $numberofrows = $result->num_rows;
  if ($numberofrows > 0 )
  {
    
    // if they are in the database register the user id
    $_SESSION['valid_user'] = $email;   
    $_SESSION['username'] =  $result->fetch_assoc()['username'];
    
    $script = '<script>alert("You are successfully logged in ! Browse our website and order your favourite food now !"); window.location.href = "index.html";</script>';
    echo $script;
    
  }
  else{
    // user input correct email but wrong password
    $query = 'select * from users '
          ."where email='$email' ";
    $result = $db->query($query);
    $databasepassword = $result->fetch_assoc()['password'];
    $databasepassword = md5($databasepassword);
    if ($databasepassword != $password) {
      $script = '<script>alert("Incorrect password! Please try again."); window.location.href = "login.html";</script>';
      echo $script;
    }

    else {
      $script = '<script>alert("You dont have an account with us. Create one now using the signup button below."); window.location.href = "login.html";</script>';
    }

  } 
  $db->close();
}
?>
