<?php
    $feedback = $_POST['text'];
    include "dbconnect.php";
    $query = 'SELECT max(customerid) FROM orders';
    $result = $db ->query($query);
    $customerid = $result ->fetch_assoc()['max(customerid)'];

    ## Insert into feedback
    $query = "INSERT INTO usersfeedback VALUES (".$customerid.", '".$feedback."')";
    $result = $db -> query($query);

    $script = '<script> alert("Thank you for your valuable feedback. We love hearing from you!")</script>';
    echo $script;
    $script = '<script> location.href="index.php" </script>';
    echo $script ; 

    $to      = 'leafybites@localhost';
    $subject = 'Feedback from customer';
    $message = $feedback;

    $headers = 'From: f31ee@localhost' . "\r\n" .
    'Reply-To: f31ee@localhost' . "\r\n" .
    'X-Mailer: PHP/' . phpversion();

    mail($to, $subject, $message, $headers,'-f31ee@localhost');
    echo ("mail sent to : ".$to);

    header("location: menu.php");
    exit;
?>