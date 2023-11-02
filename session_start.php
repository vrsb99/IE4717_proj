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

    if (!isset($_SESSION['admin'])){
        $_SESSION['admin'] = false;
    }

    $current_page = basename($_SERVER['PHP_SELF']);
    $excluded_pages = array('editable_menu.php', 'editable_items.php');

    // Auto logout for admin
    if (!in_array($current_page, $excluded_pages) && $_SESSION['admin'] == true) {
        $_SESSION['admin'] = false;
    }
?>