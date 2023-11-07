<?php
  include "session_start.php";
  function checkQuantity($db, $size_id, $quantity) {
    $cartCounts = array_count_values($_SESSION['cart']);
    $quantity = $cartCounts[$size_id] + $quantity;
    $stmt = $db->prepare("SELECT quantity FROM sizes WHERE sizeid = ?");
    $stmt->bind_param("i", $size_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $stmt->close();
    $row = $result->fetch_assoc();
    $quantity_in_stock = $row["quantity"];
    if (!is_null($quantity_in_stock) && $quantity > $quantity_in_stock) {
        return $quantity - $quantity_in_stock;
    }
    return 0;
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
  <script>
    window.onscroll = function() {
    var footer = document.querySelector('footer');
    var sidenav = document.querySelector('.sidenav');
    var footerTop = footer.offsetTop;
    var scrolled = window.scrollY + window.innerHeight;
    // console.log(window.scrollY,window.innerHeight,scrolled,footerTop);
    // If the scrolled distance is greater than the footer top, adjust sidenav
    if (scrolled > footerTop) {
        sidenav.style.bottom = (scrolled - footerTop) + 'px';
    } else {
        sidenav.style.bottom = '0';
    }
  };
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

        // Connect to database
        include "dbconnect.php";

        if (isset($_POST['size_id'])) {
          $quantity = $_POST['quantity'];
          $size_id = $_POST['size_id'];
          $quantity_check = checkQuantity($db, $size_id, $quantity);
          if ($quantity_check > 0) {
              echo '<script>alert("Sorry, we only have '.$quantity_check.' of this item left in stock.")</script>';
          } else {
              if (!isset($_SESSION['cart'])) {
                  $_SESSION['cart'] = array();
              }
              for ($i = 0; $i < $quantity; $i++) {
                  array_push($_SESSION['cart'], $_POST['size_id']);
              }
              header('location: ' . htmlspecialchars($_SERVER['PHP_SELF']) . '?' . SID);
              exit();
          }
      }
      
        echo '<p style="text-align: center;">Your shopping cart contains '.count($_SESSION['cart']).' items</p>';

        
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
              
              if (isset($items)) {
                $itemCounter = 0;
                while ($itemrow = $items->fetch_assoc()) {
                  if ($itemCounter % 3 == 0) {
                    echo '<div class="flexcontainer" style="background-color: #e3f0e7; margin-top:0px">';
                  }
                    $item_id = (int) $itemrow["itemid"];
                    $item_name = $itemrow["name"];
                    $item_description = $itemrow["description"];
                    $picture = is_null($itemrow["image"]) ? "./img/default.jpg" : "./img/".$itemrow["image"];

                    // Get all sizes for the item
                    $query = "SELECT sizeid, name, price, quantity FROM sizes WHERE itemid = ? AND (quantity IS NULL OR quantity != 0)";
                    $stmt = $db->prepare($query);
                    $stmt->bind_param("i", $item_id);
                    $stmt->execute();
                    $sizes = $stmt->get_result();
                    if ($sizes->num_rows > 0) {
                    echo '<div class="box" style="background-color:#ccd8cf">  
                          <div id="verticalflex">
                          <img src= '.$picture.' alt="Menu Image">
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
                              <input type="number" name="quantity" min="1" max="10" value="1" style="width: 50px" oninput=numericValidation(this)>
                              <button type="submit" class="addButton"> Add to Cart</button>
                        </form>
                        </div>
                        </div>';
                        $itemCounter++; // Increment counter only if item has sizes to display
                        if ($itemCounter == $items->num_rows) {
                          $remainder = $itemCounter % 3;
                          if ($remainder != 0) {
                            for ($x = 3 - $remainder; $x > 0; $x--) {
                              echo '<div class="box"></div>';
                            }
                          }
                        }
                  }
                  if ($itemCounter % 3 == 0 || $itemCounter == $items->num_rows) { 
                  // Close flexcontainer div if 3 items have been displayed or if it is the last item
                    echo '</div>';
                  }            
                }
              }
            }
          }
    echo '<script type="text/javascript" src="menu.js"></script>
          </div>';
        ?>
        
  <footer>
    <div id="footer"></div>
  </footer>
</body>

</html>