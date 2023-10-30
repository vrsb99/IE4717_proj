<?php

include "session_start.php";

if (isset($_POST["submit"])) {

    $to      = 'f31ee@localhost';
    $subject = 'Order Confirmation Letter';
    $message = 'Hello!
    Thank you so much for your business! We will get started on your order right away! In the meantime, if any questions come up, please do not hesitate to message us.';
    $headers = 'From: leafybites@localhost' . "\r\n" .
    'Reply-To: leafybites@localhost' . "\r\n" .
    'X-Mailer: PHP/' . phpversion();

    mail($to, $subject, $message, $headers,'-leafybites@localhost');
    echo ("mail sent to : ".$to);

    @ $db = new mysqli("localhost", "root", "", "leafybites");

    if (mysqli_connect_errno()) {
        $script = "<script>alert('Error: Could not connect to database. Please try again later.')</script>";
        exit;
    }

    $size_and_quantity = array();
    foreach ($_POST as $key => $value) {
        if (preg_match("/quantity_(\d+)/", $key, $matches)) {
            // var_dump($matches);  [0]=> string(10) "quantity_6" [1]=> string(1) "6" 
            $size_id = $matches[1];
            $size_and_quantity[$size_id] = $value;
        }
    }

    // Check if quantity is valid BEFORE inserting into database
    foreach ($size_and_quantity as $size_id => $quantity) {
        checkQuantity($db, $size_id, $quantity);
    }

    $email = $_POST["email"];
    date_default_timezone_set("Asia/Singapore");
    $today = date("Y-m-d H:i:s");
    $query = "INSERT INTO customers VALUES (NULL, '".$email."')";
    $result = $db->query($query);
    $customerid = $db->insert_id;

    $query = "INSERT INTO orders VALUES (NULL, ".$customerid.", '".$today."')";
    $result = $db->query($query);
    $orderid = $db->insert_id;

    foreach ($size_and_quantity as $size_id => $quantity) {
        insertOrderItem($db, $orderid, $size_id, $quantity);
        removeOrderedItem($db, $size_id, $quantity);
    }
    
    unset($_SESSION["cart"]);
    // header("location: menu.php");
    // exit;

} else if (isset($_POST['save'])) {
    $_SESSION['cart'] = array();
    
    foreach ($_POST as $key => $value) {
        if (strpos($key, 'quantity') === 0) { // strpos() means string position
            $sizeid = str_replace('quantity_', '', $key);
            $quantity = (int) $value;
            
            // Add each item back into the cart, repeated by its quantity.
            for ($i = 0; $i < $quantity; $i++) {
                $_SESSION['cart'][] = $sizeid;
            }
        }
    }
    
    header('location: menu.php');
    exit();
}

function checkQuantity($db, $size_id, $quantity) {
    $query = "SELECT quantity FROM sizes WHERE sizeid = ".$size_id;
    $result = $db->query($query);
    $row = $result->fetch_assoc();
    $quantity_in_stock = $row["quantity"];
    if (!is_null($quantity_in_stock) && $quantity > $quantity_in_stock) {
        header("location: checkout.php?error=".$size_id);
        exit;
    }
}

function insertOrderItem($db, $orderid, $size_id, $quantity) {
    $query = "SELECT itemid, price FROM sizes WHERE sizeid = ".$size_id;
    $result = $db->query($query);
    $row = $result->fetch_assoc();

    $orderid = (int) $orderid;
    $item_id = (int) $row["itemid"];
    $price = (float) $row["price"];
    $size_id = (int) $size_id;
    $quantity = (int) $quantity;

    $query = "INSERT INTO order_items VALUES (".$orderid.", ".$item_id.", ".$size_id.", ".$price.", ".$quantity.")";
    $result = $db->query($query);
}

function removeOrderedItem($db, $size_id, $quantity) {
    $query = "UPDATE sizes SET quantity = quantity - ".$quantity." WHERE sizeid = ".$size_id." AND quantity IS NOT NULL AND ".$quantity." <= quantity";
    $result = $db->query($query);
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Leafy Bites</title>
  <meta charset="utf-8">
  <link rel="stylesheet" href="stylesheet.css">
  <script src="loadPage.js"></script>  
  <script src="functionality.js"></script>
  <div class="wrapper">
    <header>
      <div class="center">
        <img class="logo" src="./img/leafylogo.png"  alt="Leafy Bites Logo" >
      </div>
      <h1>Leafy Bites</h1>
      <h1>Order Status</h1>
      <nav class="primary">
          <a href="index.php">Home</a>
          <a href="menu.php">Menu</a>
          <a id="changelink" href="past_orders.php">Past Orders</a>
          <!-- Need to add a session control to lock this Logout button before logging in -->
          <div style="float:right">
            <form action="logout.php" method="post">
            <input type = "hidden" name = "newhidden" id="newhidden" value=""></input>
            <button id="logoutbutton" name="logoutbutton" class="button" hidden onclick="userlogout()"> Logout </button>
            <a  href="checkout.php">Cart</a>  
            </form>
        </div>
      </nav>
    </header>
  </div>

  <body>
    <?php 
         
         if (!empty($_SESSION['valid_user'])){
            echo '<script> remove() </script>';
          }
          else {
            echo '<script> changelink() </script>';
          }


        // echo '<script>alert("Thank you! Your order has been placed, and the chef will start cooking shortly... ")</script>';
        echo'<div class="flexcontainer">
                <div id="verticalflex">
                    <h2>Thank you!</h2>
                    <p class="center"> Your order has been received! </p>
                    <p class="center" style="padding:30px; border-top:2px #115448 solid;border-bottom:2px #115448 solid"> <b>Order Number: '.$orderid.' </b></p>
                    <p class="center"> A confirmation email and receipt is on its way to <b>'.$email.'</b></p>
                    <p class="center"> Meanwhile, sit back and relax ! </p>

                    <form style="border:2px #115448 solid; padding:20px" action="sendfeedback.php" method="post">
                        <h2> Help Leafy Bites Improve ! </h2> 
                        <p class="center"> How was your order experience? Please tell us more about your experience.</p>
                        <textarea name="text"></textarea><br><br>
                        <input type = "submit" style="">
                    </form>
                </div>
             </div>
             ';
    ?>
    </body>
</html>