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
      <h1 style="color:#115448">Cart</h1>
      <div id="navbar"></div>
    </header>
  </div>

</head>

<body>
<!-- Container for the website -->
  <script type="text/javascript">
    function redirect(){
      location.href="menu.php";
    }
  </script>

  <?php
    session_start();
    if (!isset($_SESSION['cart'])){
      $_SESSION['cart'] = array();
    }
    
    if (isset($_GET['empty'])) {
      unset($_SESSION['cart']);
      header('location: menu.php');
      exit();
    }
    
    // How to check if _SESSION['cart'] is empty?
    if (!empty($_SESSION['cart'])) {
      
      include "dbconnect.php";

      if (isset($_GET['remove'])) {
        $remove = $_GET['remove'];
        $_SESSION['cart'] = array_diff($_SESSION['cart'], array($remove));
        header('location: ' . $_SERVER['PHP_SELF']);
        exit();
      }

      $cartCounts = array_count_values($_SESSION['cart']); // Counts occurrences of each item 
      $uniqueCart = array_keys($cartCounts); // Gets the unique items
      
      $query = "SELECT items.name as item_name, sizes.sizeid, sizes.name as size_name, sizes.price FROM items, sizes WHERE items.itemid = sizes.itemid AND sizes.sizeid IN (".implode(',', $uniqueCart).") ORDER BY sizes.sizeid";
      $result = $db->query($query);

      if (isset($_GET['error'])) {
        $error = $_GET['error'];
        while ($row = $result->fetch_assoc()) {
          if ($row['sizeid'] == $error) {
            $not_enough = $row['item_name']." (".$row['size_name'].")";
            break;
          }
        }
        echo "<script>alert('Error: Not enough quantity in stock for item ".$not_enough."')</script>";
        $result->data_seek(0);
      }

      if (isset($script)) {
        echo $script;
      }

      echo '
      <div class="flexcontainer" >
      <form action="status.php" method="post">
      <table border="0">
      <caption style="font-size:xx-large;margin-bottom:20px;color:#115448"><b>Order Details</b></caption>
      <thead>
      <tr>
        <th>Quantity</th>
        <th>Item</th>
        <th>Size</th>
        <th>Unit Price</th>
        <th>Price</th>
      </tr>
      </thead>
      <tbody>';
      
      $total = 0;
      while($row = $result->fetch_assoc()) {
          $sizeid = $row['sizeid'];
          $quantity = $cartCounts[$sizeid];
          $unit_price = $row['price'];
          $price = $unit_price * $quantity;
          echo "<tr>";
          echo "<td><input style='width:50px;border:none;text-align:center' type='number' min='0' name='quantity_".$sizeid."' value=".$quantity." onchange='priceForQuantity(this)'></td>";
          echo "<td>" . $row['item_name'] . "<br><a href='".$_SERVER["PHP_SELF"]."?remove=".$sizeid."'>Remove</a></td>";
          echo "<td>". $row['size_name'] . "</td>";
          echo "<td name='unit_price'>$" . $unit_price . "</td>";
          echo "<td name='price'>$" . number_format($price, 2) . "</td>";
          echo "</tr>";
          $total += $price;
      }      

      echo '</tbody>
        <tfoot>
        <tr>
          <td></td>
          <td></td>
          <td></td>
          <td style="text-align:center;margin-right:10px"><b>Total:</b></td><br>
          <th align="right" name="total_price" ><b>$'.number_format($total, 2).'
          </b></th>
        </tr>
        </tfoot>
      </table>
      <p><input type="submit" name="save" id="save" value="Save & Continue Shopping"> or
      <a href="'.$_SERVER['PHP_SELF'].'?empty=1">Empty Cart</a></p>
      <br>
      <h2>Customer Information</h2>

      <div class="customer_info">
      <label class="labels" for="name">*Name:</label>
      <input class="input-field" type="text" id="name" name="name" required placeholder="Enter your name here"><br><br>

      <label for="email">*E-mail:</label>
      <input type="email" id="email" name="email" required placeholder="Enter your Email-ID here"><br><br>      
      </div>
      <input type="submit" name="submit" id="submit" value="Place Order" style="font-size: large;" class="button">

      </form>
      <script type="text/javascript" src="checkout.js"></script>
      </div>';
    } 
    
    else {
      echo'<div class="flexcontainer">
              <div id="verticalflex">
                <img style="margin-top:50px;margin-left:60px;width:300px; height:300px" src="./img/emptycart.png" alt="Empty Cart" >
                <h2> Your cart is empty </h2>
                <p> Looks like you have not added anything to your cart. </p>
                <p style="text-align : center">Go ahead and explore our menu ! </p>
                <button style="margin-left:180px" class= "button" onclick ="redirect()" "> Order Now</button>
              </div>
           </div>'
            ;
      
    }
    ?>
  <footer>
    <div id="footer"></div>
  </footer>
</body>

</html>


