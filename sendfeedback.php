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
?>