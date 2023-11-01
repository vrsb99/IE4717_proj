<?php
    include "session_start.php"
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Leafy Bites</title>
  <meta charset="utf-8">
  <link rel="stylesheet" href="stylesheet.css">
  <script src="loadPage.js"></script>
  <script src="functionality.js"></script>
  <script type="text/javascript">
    function redirect(){
      location.href="menu.php";
    }
  </script>


  <div class="wrapper">
    <header>
      <div class="center">
        <img class="logo" src="./img/leafylogo.png"  alt="Leafy Bites Logo" >
      </div>
      <h1>Leafy Bites</h1>
      <h1>Past Orders</h1>
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
</head>

<body>
    <?php  
    $email = (string) $_SESSION['valid_user'];
    if (!empty($_SESSION['valid_user'])){
      echo '<script> remove() </script>';
    }
    else {
      echo '<script> changelink() </script>';
    }
    
    echo '<div class = "flexcontainer">';
    
    include "dbconnect.php";
    // I wanted to add WHERE claus, WHERE customers.email = "$_SESSION['valid_user']
    $query = "SELECT customers.customerid, customers.email,orders.orderid,orders.orderdate FROM customers JOIN orders ON customers.customerid = orders.customerid WHERE customers.email = " . "'$email'";
    $result = $db ->query($query);
    if ($result ->num_rows >0) {
        echo ' <div class="vertical flex">';
        echo '<p> Below is a complete record of your orders placed with Leafy Bites:</p>';
        
        while ($results = $result->fetch_assoc()) {
            $datetime = $results['orderdate'];
            echo'<form style="margin-top:20px" action="status.php" method="post">
                <p> Order Placed at <b> '.$datetime.' </b></p> 
                <table style="margin-top:20px" border = "0">
                <th> Quantity </th>
                <th> Price </th>
                <th> Size </th>
                <th> Unit Price </th>
                <th> Price </th>';
            
            $query = 'SELECT itemname, sizename, price, quantity, (price * quantity) as subtotal FROM order_items WHERE orderid = ' . $results['orderid'];
            
            $intermediateresult=$db->query($query);
            
            $total = 0;
            while($row = $intermediateresult->fetch_assoc()){
            echo "<tr>";
            echo "<td>" . $row['quantity'] . "</td>";
            echo "<td>" . $row['itemname'] . "</td>";
            echo "<td>". $row['sizename'] . "</td>";
            echo "<td>$" . $row['price'] . "</td>";
            echo "<td>$" . $row['subtotal'] . "</td>";
            echo "</tr>";
            $total += $row['subtotal'];
            }
            echo "<tr>";
            echo "<td></td>";
            echo "<td></td>";
            echo "<td></td>";
            echo "<td><b>Total</b></td>";
            echo "<td><b>$total<b></td>";
            echo "</tr>";
            echo '</table>';
            echo '<br>';
        }
        echo'</div>';
        echo'</div>';
    }

    else{
        echo'
              <div id="verticalflex">
                <img style="margin-top:50px;margin-left:60px;width:300px; height:300px" src="./img/emptyorder.png" alt="Empty Cart" >
                <h2> Oopss... your order history is empty. </h2>
                <p style="text-align : center"> You have not placed an order before. </p>
                <p style="text-align : center">Go ahead and explore our menu! </p>
                <button style="margin-left:150px" class= "button" onclick ="redirect()"> Order Now</button>
              </div>
           </div>';
    }


    ?>

    <footer>
        <div id="footer"></div>    
    </footer>
</body>

</html>