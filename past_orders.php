<?php
    session_start();
    var_dump($_SESSION['valid_user']);

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Leafy Bites</title>
  <meta charset="utf-8">
  <link rel="stylesheet" href="stylesheet.css">
  <script src="loadPage.js"></script>

  <div class="wrapper">
    <header>
      <div class="center">
        <img class="logo" src="./img/leafylogo.png"  alt="Leafy Bites Logo" >
      </div>
      <h1 style="color:#115448">Leafy Bites</h1>
      <h1 style="color:#115448">Past Orders</h1>
      <div id="navbar"></div>
    </header>
  </div>
</head>

<body>
    <?php  
    $email = (string) $_SESSION['valid_user'];

    echo '<div class = "flexcontainer">
    <form action="status.php" method="post">
    <table border = "0">
    <caption style="font-size:xx-large;margin-bottom:20px;color:#115448"><b>Order Details</b></caption>
    <th> Quantity </th>
    <th> Price </th>
    <th> Size </th>
    <th> Unit Price </th>
    <th> Price </th>';
    

    include "dbconnect.php";
    // I wanted to add WHERE claus, WHERE customers.email = "$_SESSION['valid_user']
    $query = "SELECT customers.customerid, customers.email,orders.orderid FROM customers JOIN orders ON customers.customerid = orders.customerid WHERE customers.email = " . "'$email'";
    $result = $db ->query($query);

    while ($results = $result->fetch_assoc()) {
        
        $query = 'SELECT order_items.orderid,order_items.sizeid,sizes.name as sizename,order_items.itemid,items.name,order_items.price,order_items.quantity, (order_items.quantity * order_items.price) as subtotal
                  FROM order_items
                  INNER JOIN items ON items.itemid = order_items.itemid
                  INNER JOIN sizes ON sizes.sizeid = order_items.sizeid
                  WHERE order_items.orderid =' . $results['orderid'];
        
        $intermediateresult=$db->query($query);
        
        while($row = $intermediateresult->fetch_assoc()){
          echo "<tr>";
          echo "<td>" . $row['quantity'] . "</td>";
          echo "<td>" . $row['name'] . "</td>";
          echo "<td>". $row['sizename'] . "</td>";
          echo "<td>$" . $row['price'] . "</td>";
          echo "<td>$" . $row['subtotal'] . "</td>";
          echo "</tr>";
          echo "</tbody>";
  
        }
        
    }
    
    echo '</table>
    </div>';
    
    ?>

    <footer>
        <div id="footer"></div>    
    </footer>
</body>

</html>