<?php
    //prompt function
    function prompt($prompt_msg){
        echo("<script type='text/javascript'> var answer = prompt('".$prompt_msg."'); </script>");

        $answer = "<script type='text/javascript'> document.write(answer); </script>";
        return($answer);
    }
    //program
    $prompt_msg = "Please input admin password.";
    $password = prompt($prompt_msg);
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