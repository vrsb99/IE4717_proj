<?php
  include "session_start.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Leafy Bites</title>
  <meta charset="utf-8">
  <link rel="stylesheet" href="stylesheet.css">
  <script src="loadPage.js"></script>
  <script src="functionality.js"></script>
  <script>
  function notify(){
      alert("Item added into cart.")
    }
  </script>
</head>

<body id="menu">
<!-- Container for the website -->
  <div class="wrapper">
    <header>
      <div class="center">
        <img class="logo" src="./img/leafylogo.png"  alt="Leafy Bites Logo" >
      </div>
      <h1 style="color:#115448">Leafy Bites</h1>
      <h1 style="color:#115448">Menu</h1>

      <!-- Navigation bar for all pages -->
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
        </form>
      </nav>
    </header>

  </div>
        <?php
        /*
        Flow:
        1. Connect to database
        2. Get all categories
        3. Iterate through each category
        4. Get all items in the category
        5. Iterate through each item
        6. Get all sizes for the item
        7. Iterate through each size
        */

        if (!empty($_SESSION['valid_user'])){
          echo '<script> remove() </script>';
        }
        else {
          echo '<script> changelink() </script>';
        }

        if (isset($_POST['size_id'])) {
          array_push($_SESSION['cart'], $_POST['size_id']);
          header('location: ' . htmlspecialchars($_SERVER['PHP_SELF']) . '?' . SID);
          exit();
      }
      
        echo '<p style="text-align: center;">Your shopping cart contains '.count($_SESSION['cart']).' items</p>';

        // Connect to database
        include "dbconnect.php";
        // Get all categories
        $query = "SELECT * FROM category";
        $categories = $db->query($query);

        if (isset($categories)) {
          echo '<div class="leftcolumn">
                <nav class="sidenav">
                  <ul>';
          while ($catrow = $categories->fetch_assoc()) {
            $cat_id = $catrow['categoryid'];
            $cat_name = $catrow['name'];
            echo '<li><a href="#'.$cat_id.'">'.$cat_name.'</a></li><br><br><br>';
          }
          echo '</ul>
                </nav>
                </div>';
        }

        $categories -> data_seek(0);
        echo '<div class="rightcolumn">';
          if (isset($categories)){
            while ($catrow = $categories->fetch_assoc()) {
              $cat_id = $catrow['categoryid'];
              $cat_name = $catrow['name'];
              echo '<h2 style="font-size:xx-large;margin-right:150px" id="'.$cat_id.'">'.$cat_name.'</h2>';

              // Get all items in the category
              $query = "SELECT * FROM items WHERE categoryid = ".$cat_id;
              $items = $db->query($query);
              $num_items = $items->num_rows;
              
              if (isset($items)) {
                $itemCounter = 0;
                while ($itemrow = $items->fetch_assoc()) {
                  if ($itemCounter % 3 == 0) {
                    echo '<div class="flexcontainer" style="background-color: #e3f0e7; margin-top:0px">';
                  }
                    $item_id = (int) $itemrow["itemid"];
                    $item_name = $itemrow["name"];
                    $item_description = $itemrow["description"];

                    // Get all sizes for the item
                    $query = "SELECT sizeid, name, price, quantity FROM sizes WHERE itemid = (?)";
                    $stmt = $db->prepare($query);
                    $stmt->bind_param("i", $item_id);
                    $stmt->execute();
                    $sizes = $stmt->get_result();
                    $num_rows = $item_id % 3;
                    echo '<div class="box">  
                    <div id="verticalflex">
                        <img src="./img/roastchicken.jpg" width=200 height=200 alt="McChicken">
                        <p style="font-size: 20px">
                            <b>'.$item_name.'</b> <br>
                            '.wordwrap($item_description, 30, "<br>").'
                        </p>
                        <form action="'.htmlspecialchars($_SERVER['PHP_SELF']).'" method="post">';
                        echo '<select name="size_id">';

                        if (isset($sizes)) {
                            while ($sizerow = $sizes->fetch_assoc()) {
                              $size_quantity = htmlspecialchars($sizerow["quantity"]);
                              $size_id = htmlspecialchars($sizerow["sizeid"]);
                              $size_name = htmlspecialchars($sizerow["name"]);
                              $size_price = htmlspecialchars($sizerow["price"]);
                              if (is_null($size_quantity) || $size_quantity != 0) {
                                echo '<option class="option" value="'.$size_id.'">'.$size_name.' ($'.$size_price.')</option>';
                                echo ' &nbsp';
                            }
                        }
                    }
                       
                        echo '</select>

                              <button type="submit" class="addButton" onclick="notify()"> Add to Cart</button>
                        </form>';
              echo '  </div>
                  </div>';
                  if ($itemCounter % 3 == 2) {
                    echo '</div>';
                  }
                  $itemCounter++;
                }
              }
              echo '</div>';
              
            }
          }
          echo '</div>';
        ?>
        
  <footer>
    <div id="footer"></div>
  </footer>
</body>

</html>