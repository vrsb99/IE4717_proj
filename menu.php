<!DOCTYPE html>
<html lang="en">
<head>
  <title>Leafy Bites</title>
  <meta charset="utf-8">
  <link rel="stylesheet" href="stylesheet.css">
  <script src="loadPage.js"></script>
  
</head>

<body>
<!-- Container for the website -->
  
    <header>
      <div class="wrapper">
        <div class="center">
          <img class="logo" src="./img/leafylogo.png"  alt="Leafy Bites Logo" >
        </div>
        <h1>Leafy Bites</h1>
        <h1>Menu</h1>
        <div id="navbar"></div>
      </div>
    </header>
        
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

    session_start();
    if (!isset($_SESSION['cart'])){
      $_SESSION['cart'] = array();
    }

    if (isset($_GET['add'])) {
      $_SESSION['cart'][] = $_GET['add'];
      header('location: ' . $_SERVER['PHP_SELF']. '?' . SID);
      exit();
    }
    echo '<p style="margin-left:30px">Your shopping cart contains '.count($_SESSION['cart']).' items</p>';

    // Connect to database
    @ $db = new mysqli('localhost', 'root', '', 'leafybites');

    if (mysqli_connect_errno()) {
        $script = '<script>alert("Error: Could not connect to database. Please try again later.")</script>';
        exit;
    }
    
    // Get all categories
    $query = "SELECT * FROM category";
    $categories = $db->query($query);
    
   

    if (isset($categories)) {
      echo '<div id="wrapper">';
        echo  '<div class="leftcol">';
        echo  '<nav class="sidenav">';
        echo  '<ul>';

      while ($catrow = $categories->fetch_assoc()) {
        $cat_id = $catrow['categoryid'];
        $cat_name = $catrow['categoryname'];
        echo '<li><a href="#'.$cat_id.'">'.$cat_name.'</a></li>';
        echo '<br>';
        echo '<br>';
        echo '<br>';
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
          $cat_name = $catrow['categoryname'];
          echo '<h2 style="padding-top: 50px; font-size:xx-large;" id="'.$cat_id.'">'.$cat_name.'</h2>';
          echo '<div class="flexcontainer" style="background-color: #e3f0e7; margin-top:0px">';

          // Get all items in the category
          $query = "SELECT * FROM items WHERE categoryid = ".$cat_id;
          $items = $db->query($query);
          $num_items = $items->num_rows;
          
          if (isset($items)) {
            while ($itemrow = $items->fetch_assoc()) {
                $item_id = $itemrow["itemid"];
                $item_name = $itemrow["itemname"];
                $item_description = $itemrow["itemdescription"];

                // Get all sizes for the item
                $query = "SELECT * FROM sizes WHERE itemid = ".$item_id;
                $sizes = $db->query($query);

                echo '<div class="box" >  
                        <div id="verticalflex" >
                        <img src="./img/roastchicken.jpg" width=200 height=200 alt="McChicken">
                        <p style="font-size: 20px">
                        <b>'.$item_name.'</b> <br>
                        '.wordwrap($item_description, 30, "<br>").'
                        </p>
                        
                        <select>';

                    if (isset($sizes)) {
                        while ($sizerow = $sizes->fetch_assoc()) {
                          $size_id = $sizerow["sizeid"];
                          $size_name = $sizerow["size"];
                          $size_price = $sizerow["sizeprice"];
                          echo '<option value='.$size_id.'>'.$size_name.' ($'.$size_price.')</option>';
                        }
                    }
                echo '</select>
                      <a class="addButton" href='.$_SERVER['PHP_SELF'].'?add='.$size_id.'>Add to Cart</a>
                      </div>
                      </div>';
            }
          }
          echo '</div>';
        }
      }
      echo '</div>';
    echo '</div>';
    
    ?>


  <footer>
    <div id="footer"></div>
  </footer>   
</body>

</html>