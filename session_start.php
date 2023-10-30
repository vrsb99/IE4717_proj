<?php
    session_start();
    if (!isset($_SESSION['valid_user'])){
          $_SESSION['valid_user'] = array();
        }

    if(!isset($_SESSION['username'])){
        $_SESSION['username'] =array();
    }

    if (!isset($_SESSION['cart'])){
        $_SESSION['cart'] = array();
    }
?>