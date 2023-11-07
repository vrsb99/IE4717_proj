<?php
    // Start session if not started
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    //prompt function
    $password = $_REQUEST['hidden'];
    $password = md5($password);
    
    include "dbconnect.php";
    $query = "SELECT * FROM admin";
    $result = $db -> query($query);
    $adminpassword = $result->fetch_assoc()['password'];

    if ($adminpassword == $password){
        $_SESSION['admin'] = true;
        header("location: editable_menu.php");
        exit();
    } else {
        $_SESSION["admin"] = false;
        echo "<script>alert('Incorrect password ! Please try again.')</script>";
        $previous = "<script>javascript:history.go(-1)</script>";
        echo $previous;
        exit();
    }
?>