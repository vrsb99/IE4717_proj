<?php   

include "dbconnect.php";
session_start();
$script = '<script>alert("You will receive an email to reset your password if you have an account with us")</script>';
echo $script;

$email= $_POST['subscribeemail'];
var_dump($email);

// $token = bin2hex(random_bytes(16));

// $token_hash = hash("sha256", $token);

// $expiry = date("Y-m-d H:i:s", time() + 60 * 20)

function randomPassword() {
  $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
  $pass = array(); //remember to declare $pass as an array
  $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
  for ($i = 0; $i < 8; $i++) {
      $n = rand(0, $alphaLength);
      $pass[] = $alphabet[$n];
  }
  return implode($pass); //turn the array into a string
};

$tempPass = randomPassword();
// var_dump($tempPass);
$hashTempPass = md5($tempPass);

$query = "SELECT * FROM users";
$results = $db->query($query);
while ($rows = $results -> fetch_assoc()){
  
  if ($rows['email'] == $email) {
    echo'<script>alert("Email Found")</script>';

    $query = 'Update users '
          ."SET password = '$hashTempPass' "
          ."where email=" . "'$email' ";
          
    $result = $db -> query($query);


$to      = 'f31ee@localhost';
$subject = 'Password Reset Email';
$message = 'Hello '.$email.',

Looks like you are having trouble logging in your account in Leafy Bites. Fear not, we have generated a temporary password for you.

        Temporary Password : '.$tempPass.'

Please use this newly generated password to log in to your account.

Thank you.

From
Leafy Bites Management
';

$headers = 'From: leafybites@localhost' . "\r\n" .
'Reply-To: leafybites@localhost' . "\r\n" .
'X-Mailer: PHP/' . phpversion();

mail($to, $subject, $message, $headers,'-leafybites@localhost');
echo ("mail sent to : ".$to);

header("location: login.html");
}


}


// $previous = "<script>location.href='login.html'</script>";
// echo $previous;
// exit();
?>