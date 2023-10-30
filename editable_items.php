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
      <nav class="primary">
        <a href="index.php">Home</a>
        <a href="menu.php">Menu</a>
        <a id="changelink" href="past_orders.php">Past Orders</a>

        <!-- Need to add a session control to lock this Logout button before logging in -->
        <div style="float:right">
          <button id="logoutbutton" name="logoutbutton" class="button" onclick="logout()" hidden> Logout </button>
          <a  href="checkout.php">Cart</a>
        </div>
    </nav>
    </header>
  </div>

</head>

<body>
<!-- Container for the website -->


  <?php
    if (!empty($_POST['item_id'])) {
      
      include "dbconnect.php";

      $item_id = $_POST['item_id'];
      
      $query = "SELECT items.name as item_name, items.description, sizes.sizeid, sizes.name as size_name, sizes.price, sizes.quantity FROM items, sizes WHERE items.itemid = sizes.itemid AND items.itemid = ".$item_id;
      $result = $db->query($query);
      $row = $result->fetch_assoc();
      $item_name = $row['item_name'];
      $item_description = $row['description'];

      echo '
      <div class="flexcontainer" >
      <form action='.$_SERVER['PHP_SELF'].' method="post">
      <label for="item_name" style="font-size: large;">Item Name</label><br>
      <input type="text" name="item_name" value="'.$item_name.'" ><br><br>
      <label for="item_description" style="font-size: large;">Description</label><br>
      <input type="text" name="item_description" value="'.$item_description.'" ><br><br>
      <table border="0">
      <caption style="font-size:xx-large;margin-bottom:20px;color:#115448"><b>Size Details</b></caption>
      <thead>
      <tr>
        <th>Size Name
        <th>Price</th>
        <th>Quantity</th>
      </tr>
      </thead>
      <tbody>';
      $result -> data_seek(0);
      while($row = $result->fetch_assoc()) {
          $sizeid = $row['sizeid'];
          $size_name = $row['size_name'];
          $unit_price = $row['price'];
          $quantity = $row['quantity'];
          echo "<tr>";
          echo "<td><input style='width:50px;text-align:center' type='text' name='size_name_".$sizeid."' value=".$size_name."></td>";
          echo "<td><input style='width:50px;text-align:center' type='number' min='0' name='price_".$sizeid."' value=".$unit_price."></td>";
          echo "<td><input style='width:50px;text-align:center' type='number' name='quantity_".$sizeid."' value=" . (is_null($quantity) ? "" : $quantity) . "></td>";
          // Shows empty value if quantity is null else shows quantity
          echo "</tr>";
      }      

      echo '</tbody>
      </table>
      <input type="button" name="Add" value="Add Size" onclick="" style="font-size: large;" class="button">
      <input type="submit" name="submit" id="submit" value="Place Order" style="font-size: large;" class="button">
      </form>
      <script type="text/javascript" src="checkout.js"></script>
      </div>';
    } else if (!empty($_POST['category_id'])) {
      include "dbconnect.php";

      echo '
      <div class="flexcontainer" >
      <form action='.$_SERVER['PHP_SELF'].' method="post">
      <label for="item_name" style="font-size: large;">Item Name</label><br>
      <input type="text" name="item_name" ><br><br>
      <label for="item_description" style="font-size: large;">Description</label><br>
      <input type="text" name="item_description" ><br><br>
      <table border="0">
      <caption style="font-size:xx-large;margin-bottom:20px;color:#115448"><b>Size Details</b></caption>
      <thead>
      <tr>
        <th>Size Name
        <th>Price</th>
        <th>Quantity</th>
      </tr>
      </thead>
      <tbody>
        <tr>
          <td><input style="width:50px;text-align:center" type="text" name="size_name_new_1"></td>
          <td><input style="width:50px;text-align:center" type="number" min="0" name="price_new_1"></td>
          <td><input style="width:50px;text-align:center" type="number" name="quantity_new_1"></td>
        </tr>
      </tbody>
      </table>
      <input type="button" name="Add" value="Add Size" onclick="" style="font-size: large;" class="button">
      <input type="submit" name="submit" id="submit" value="Place Order" style="font-size: large;" class="button">
      </form>
      <script type="text/javascript" src="checkout.js"></script>
      </div>';
    }
    ?>
  <footer>
    <div id="footer"></div>
  </footer>
</body>

</html>
