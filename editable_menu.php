<!DOCTYPE html>
<html lang="en">
<head>
  <title>Leafy Bites</title>
  <meta charset="utf-8">
  <link rel="stylesheet" href="stylesheet.css">
  <script src="loadPage.js"></script>
  <script>
    function notify(){
      alert("Item added into cart.")
    }
  </script>
</head>

<body>
<!-- Container for the website -->
  <div class="wrapper">
    <header>
      <div class="center">
        <img class="logo" src="./img/leafylogo.png"  alt="Leafy Bites Logo" >
      </div>
      <h1 style="color:#115448">Leafy Bites</h1>
      <h1 style="color:#115448">Menu</h1>
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
        // Connect to database
        include "dbconnect.php";

        // Insert new category
        if (isset($_POST['cat_name'])) {
          $cat_name = $_POST['cat_name'];
          $query = "INSERT INTO category VALUES (NULL, ".$cat_name.")";
          $formatted = $db->prepare("INSERT INTO category (name) VALUES (?)");
          $formatted->bind_param("s", $cat_name);
          $formatted->execute();
          $formatted->close();
        }

        if (isset($_POST['cat_id'])) {
            $cat_id = $_POST['cat_id'];
            $formatted = $db->prepare("DELETE FROM category WHERE categoryid = ?");
            $formatted->bind_param("i", $cat_id);
            $formatted->execute();
            $formatted->close();
        }

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
            echo '<li>
            <a href="#'.$cat_id.'">'.$cat_name.'</a>
            <form action="'.$_SERVER['PHP_SELF'].'" method="POST" style="display:inline;"> 
              <input type="hidden" name="cat_id" value="'.$cat_id.'">
              <input type="submit" value="Delete">
            </form>
            </li><br><br><br>';
          }
          
          echo '<li>
                <form action="'.$_SERVER['PHP_SELF'].'" method="POST">
                <input type="text" name="cat_name" placeholder="New Category">
                <input type="submit" value="Add">
                </form>
                </li><br><br><br>
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
              echo '<form action="editable_items.php" method="post">
              <input type="hidden" name="category_id" value="'.$cat_id.'">
              <button type="submit" class="addNewItemButton">Add New Item</button>
              </form><br><br>
              <div class="flexcontainer" style="background-color: #e3f0e7; margin-top:0px">';

              // Get all items in the category
              $query = "SELECT * FROM items WHERE categoryid = ".$cat_id;
              $items = $db->query($query);
              $num_items = $items->num_rows;
              
              if (isset($items)) {
                while ($itemrow = $items->fetch_assoc()) {
                    $item_id = $itemrow["itemid"];
                    $item_name = $itemrow["name"];
                    $item_description = $itemrow["description"];

                    // Get all sizes for the item
                    $query = "SELECT * FROM sizes WHERE itemid = ".$item_id;
                    $sizes = $db->query($query);

                    echo '<div class="box">  
                    <div id="verticalflex">
                        <img src="./img/roastchicken.jpg" width=200 height=200 alt="McChicken">
                        <p style="font-size: 20px">
                            <b>'.$item_name.'</b> <br>
                            '.wordwrap($item_description, 30, "<br>").'
                        </p>
                        <form action="editable_items.php" method="post">';
                        echo '<input type="hidden" name="item_id" value="'.$item_id.'">';
    
                        if (isset($sizes)) {
                            while ($sizerow = $sizes->fetch_assoc()) {
                              $size_name = htmlspecialchars($sizerow["name"]);
                              $size_price = htmlspecialchars($sizerow["price"]);
                              echo '<p style="font-size: 16px">'.$size_name.' ($'.$size_price.')</p>';
                            }
                        }
                echo    '<button type="submit" class="editButton">Edit Item</button>
                        </form>';
              echo '  </div>
                  </div>';
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