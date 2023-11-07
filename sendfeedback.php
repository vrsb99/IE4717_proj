<?php
    $feedback = $_POST['text'];
    include "dbconnect.php";
    $stmt = $db->prepare('SELECT max(customerid) FROM orders');
    $stmt->execute();
    $result = $stmt->get_result();
    $customerid = $result->fetch_assoc()['max(customerid)'];

    ## Insert into feedback
    $stmt = $db->prepare("INSERT INTO usersfeedback (customerid, feedback) VALUES (?, ?)");
    $stmt->bind_param("is", $customerid, $feedback);
    $stmt->execute();

    $to      = 'leafybites@localhost';
    $subject = 'Feedback from customer';
    $message = $feedback;

    $headers = 'From: f31ee@localhost' . "\r\n" .
    'Reply-To: f31ee@localhost' . "\r\n" .
    'X-Mailer: PHP/' . phpversion();

    mail($to, $subject, $message, $headers,'-f31ee@localhost');
    echo ("mail sent to : ".$to);

    $script = '<script> alert("Thank you for your valuable feedback. We love hearing from you!")</script>';
    echo $script; 
    
    echo '<script>location.href = "index.php"</script>';
    exit;
?>