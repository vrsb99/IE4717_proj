<?php
    $to      = 'f31ee@localhost';
    $subject = 'You have subscribed to Leafy Bites!';
    $message = 'Hello ! 
    
Hurray ! Subscribing to our newsletter was a very SMART decision. 
We will be intouch regularly with up to date news, offers, and much more.
In the mean time, find out more about us and our expert friends and the inspiration behind our restaurant!
    
Thank you and have a GREAT day ahead!
    
From:
Leafy Bites Management';
    $headers = 'From: leafybites@localhost' . "\r\n" .
    'Reply-To: leafybites@localhost' . "\r\n" .
    'X-Mailer: PHP/' . phpversion();

    mail($to, $subject, $message, $headers,'-leafybites@localhost');
    echo ("mail sent to : ".$to);
    echo "<script>alert('Congratulations! You are now subscribed to our newsletter!')</script>";
    $previous = "<script>javascript:history.go(-1)</script>";
    echo $previous;
    exit();
?>