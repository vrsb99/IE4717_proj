<?php
    //prompt function
    $password = $_REQUEST['hidden'];
    var_dump($password);

    include "dbconnect.php";
    $query = "SELECT * FROM admin";
    $result = $db -> query($query);
    $adminpassword = $result->fetch_assoc()['password'];
    var_dump($adminpassword);

    if ($adminpassword == $password){
        $script = '<script>location.href="editable_menu.php"; </script>';
        echo $script;
    }
    else {
        echo "<script>alert('Incorrect password ! Please try again.')</script>";
        $previous = "<script>javascript:history.go(-1)</script>";
        echo $previous;
        exit();
    }

?>