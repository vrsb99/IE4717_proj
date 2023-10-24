<?php
session_start();
if (isset($_POST["submit"])) {
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

    $email = $_POST["email"];
    $today = date("Y-m-d H:i:s");
    $query = "INSERT INTO orders VALUES (NULL, '".$email."', '".$today."')";
    $result = $db->query($query);
    $orderid = $db->insert_id;

    foreach ($size_and_quantity as $size_id => $quantity) {
        insertOrderItem($db, $orderid, $size_id, $quantity);
    }
    unset($_SESSION["cart"]);
    header("location: menu.php");
    exit;
} else if (isset($_POST['save'])) {
    $_SESSION['cart'] = array();
    
    // Loop through each of the received items.
    foreach ($_POST as $key => $value) {
        if (strpos($key, 'quantity_') === 0) { // strpos() means string position
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

function insertOrderItem($db, $orderid, $size_id, $quantity) {
    $query = "SELECT categoryid, itemid, sizeprice FROM sizes WHERE sizeid = ".$size_id;
    $result = $db->query($query);
    $row = $result->fetch_assoc();

    $orderid = (int) $orderid;
    $categoryid = (int) $row["categoryid"];
    $item_id = (int) $row["itemid"];
    $price = (float) $row["sizeprice"];
    $size_id = (int) $size_id;
    $quantity = (int) $quantity;

    $query = "INSERT INTO order_items VALUES (".$orderid.", ".$categoryid.", ".$item_id.", ".$size_id.", ".$price.", ".$quantity.")";
    $result = $db->query($query);
}
?>