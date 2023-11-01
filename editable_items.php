<!DOCTYPE html>
<html lang="en">
<head>
  <title>Leafy Bites</title>
  <meta charset="utf-8">
  <link rel="stylesheet" href="stylesheet.css">
  <script src="loadPage.js"></script>  
  <script src="functionality.php"></script>
  <div class="wrapper">
    <header>
      <div class="center">
        <img class="logo" src="./img/leafylogo.png"  alt="Leafy Bites Logo" >
      </div>
      <h1>Leafy Bites</h1>
      <h1>Edit Items</h1>
      <nav class="primary">
        <a href="editable_menu.php"> << Back to Admin Menu</a>

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
  if (isset($_POST['submit'])) {
    $cat_id = $_POST['category_id'];
    
    include "dbconnect.php";

    // Handle new or existing items
    if (isset($_POST['item_id'])) {
        $item_id = $_POST['item_id'];
        $item_name = $_POST['item_name'];
        $item_description = $_POST['item_description'];
        
        // Update existing item details
        $stmt = $db->prepare("UPDATE items SET name=?, description=? WHERE itemid=?");
        $stmt->bind_param("ssi", $item_name, $item_description, $item_id);
        $stmt->execute();
    } else {
        $item_name = $_POST['item_name'];
        $item_description = $_POST['item_description'];
        
        // Insert new item and get its ID
        $stmt = $db->prepare("INSERT INTO items (categoryid, name, description) VALUES (?, ?, ?)");
        $stmt->bind_param("iss", $cat_id, $item_name, $item_description);
        $stmt->execute();
        $item_id = $db->insert_id;
    }
    
    // Handle sizes (both new and existing)
    for ($i = 1; isset($_POST['size_name_' . $i]); $i++) {
        if (isset($_POST['size_id_' . $i])) {
            // Get details of existing size
            $sizeid = $_POST['size_id_' . $i];
            $size_name = $_POST['size_name_' . $i];
            $price = (double) $_POST['price_' . $i];
            $quantity = $_POST['quantity_' . $i] == "" ? NULL : (int) $_POST['quantity_' . $i];

          if ($quantity != NULL) {
              $quantity = (int) $_POST['quantity_' . $i];
              $stmt = $db->prepare("UPDATE sizes SET name=?, price=?, quantity=? WHERE sizeid=?");
              $stmt->bind_param("sdii", $size_name, $price, $quantity, $sizeid);
          } else {
              $stmt = $db->prepare("UPDATE sizes SET name=?, price=?, quantity=NULL WHERE sizeid=?");
              $stmt->bind_param("sdi", $size_name, $price, $sizeid);
          }
          $stmt->execute();
        } else {
            // Get details of new size
            $size_name = $_POST['size_name_' . $i];
            $price = (double) $_POST['price_' . $i];
            $quantity = $_POST['quantity_' . $i] == "" ? NULL : (int) $_POST['quantity_' . $i];

            // Insert new size
            if ($quantity != NULL) {
                $quantity = (int) $_POST['quantity_' . $i];
                $stmt = $db->prepare("INSERT INTO sizes (itemid, name, price, quantity) VALUES (?, ?, ?, ?)");
                $stmt->bind_param("isdi", $item_id, $size_name, $price, $quantity);
            } else {
                $stmt = $db->prepare("INSERT INTO sizes (itemid, name, price, quantity) VALUES (?, ?, ?, NULL)");
                $stmt->bind_param("isd", $item_id, $size_name, $price);
            }
            $stmt->execute();
        }
    }
    // header("location: editable_menu.php") ;
  } elseif (isset($_POST['item_id'])) {
      
      include "dbconnect.php";

      $item_id = $_POST['item_id'];
      $cat_id = $_POST['category_id'];
      
      $query = "SELECT items.name as item_name, items.description, sizes.sizeid, sizes.name as size_name, sizes.price, sizes.quantity FROM items, sizes WHERE items.itemid = sizes.itemid AND items.itemid = ".$item_id;
      $result = $db->query($query);
      $row = $result->fetch_assoc();
      $item_name = $row['item_name'];
      $item_description = $row['description'];

      echo '
      <div class="flexcontainer" >
      <form action='.$_SERVER['PHP_SELF'].' method="post">
      <input type="hidden" name="item_id" value="'.$item_id.'">
      <input type="hidden" name="category_id" value="'.$cat_id.'">
      <label for="item_name" style="font-size: large;">Item Name</label><br>
      <input type="text" name="item_name" required value="'.$item_name.'" ><br><br>
      <label for="item_description" style="font-size: large;">Description</label><br>
      <input type="text" name="item_description" required value="'.$item_description.'" ><br><br>
      <table border="0">
      <caption style="font-size:xx-large;margin-bottom:20px;color:#115448"><b>Size Details</b></caption>
      <thead>
      <tr>
        <th>Size Name
        <th>Price</th>
        <th>Quantity</th>
      </tr>
      </thead>
      <tbody id="sizeTableBody">';
      $result -> data_seek(0);
      $i = 1;
      while($row = $result->fetch_assoc()) {
          $sizeid = $row['sizeid'];
          $size_name = $row['size_name'];
          $unit_price = $row['price'];
          $quantity = $row['quantity'];
          echo "<tr>";
          echo "<td><input style='width:50px;text-align:center' type='text' required name='size_name_".$i."' value=".$size_name."></td>";
          echo "<td><input style='width:50px;text-align:center' type='number' required min='0' step='0.01' name='price_".$i."' oninput='numericValidation(this)' value=".$unit_price."></td>";
          echo "<td><input style='width:50px;text-align:center' type='number' name='quantity_".$i."' oninput='numericValidation(this)' value=".$quantity."></td>";
          echo "<input type='hidden' name='size_id_".$i."' id='size_id_".$i."' value=".$sizeid.">";
          // Shows empty value if quantity is null else shows quantity
          echo "</tr>";
          $i++;
      }      

      echo '</tbody>
      </table>
      <input type="button" name="Add" value="Add Size" onclick="addSizeRow()" style="font-size: large;" class="button">
      <input type="submit" name="submit" value="Edit Sizes" style="font-size: large;" class="button"> 
      </form>
      <script type="text/javascript" src="editable_items.js"></script>
      </div>';
    } elseif (isset($_POST['category_id'])) {
      
      $cat_id = $_POST['category_id'];

      echo '
      <div class="flexcontainer" >
      <form action='.$_SERVER['PHP_SELF'].' method="post">
      <input type="hidden" name="category_id" value="'.$cat_id.'">
      <label for="item_name" style="font-size: large;">Item Name</label><br>
      <input type="text" required name="item_name" ><br><br>
      <label for="item_description" style="font-size: large;">Description</label><br>
      <input type="text" required name="item_description" ><br><br>
      <table border="0">
      <caption style="font-size:xx-large;margin-bottom:20px;color:#115448"><b>Size Details</b></caption>
      <thead>
      <tr>
        <th>Size Name
        <th>Price</th>
        <th>Quantity</th>
      </tr>
      </thead>
      <tbody id="sizeTableBody">
        <tr>
          <td><input style="width:50px;text-align:center" required type="text" name="size_name_1"></td>
          <td><input style="width:50px;text-align:center" required type="number" min="0" step="0.01" name="price_1" oninput="numericValidation(this)"></td>
          <td><input style="width:50px;text-align:center" type="number" name="quantity_1" oninput="numericValidation(this)"></td>
        </tr>
      </tbody>
      </table>
      <input type="button" name="Add" value="Add Size" onclick="addSizeRow()" style="font-size: large;" class="button">
      <input type="submit" name="submit" value="Add New Item" style="font-size: large;" class="button">
      </form>
      <script type="text/javascript" src="editable_items.js"></script>
      </div>';
    }
    ?>
  <footer>
    <div id="footer"></div>
  </footer>
</body>

</html>
