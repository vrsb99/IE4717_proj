<?php
    session_start();
    $check = $_REQUEST['newhidden'];

    if($check == true){
        unset($_SESSION['valid_user']);
        unset($_SESSION['username']);
        $script = '<script>alert("Succesfully logout.")</script>';
        echo $script;
        $previous = '<script>location.href ="index.php"</script>';
        echo $previous;
        exit();
    }
    else {
        $previous = "<script>javascript:history.go(-1)</script>";
        echo $previous;
        exit();
    }
    
    

?>