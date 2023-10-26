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
    header("location: menu.php");
    exit;

} else if (isset($_POST['save'])) {
    $_SESSION['cart'] = array();
    
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