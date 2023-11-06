<!DOCTYPE html>
<html lang="en">
<head>
  <title>Leafy Bites</title>
  <meta charset="utf-8">
  <link rel="stylesheet" href="stylesheet.css">
  <script src="loadPage.js"></script>
  <script src="functionality.js"></script>
</head>

<body>
<!-- Container for the website -->
  <div class="wrapper">
    <header>
      <div class="center">
        <img class="logo" src="./img/leafylogo.png"  alt="Leafy Bites Logo" >
      </div>
      <h1>Leafy Bites</h1>
      <h1>Admin Menu</h1>
        <!-- Need to add a session control to lock this Logout button before logging in -->
    <nav>
      <div style="float:right">
        <input type="button" class="button" onclick = "exit()" value="Quit Editing"></input>
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
        include "session_start.php";
        if ($_SESSION['admin'] == false) {
          header('location: index.php');
          exit();
        }

        if (isset($_POST['delete_item_id'])) {
          $delete_item_id = $_POST['delete_item_id'];

          $stmt = $db->prepare("DELETE FROM sizes WHERE itemid = ?");
          $stmt->bind_param("i", $delete_item_id);
          $stmt->execute();
          $stmt->close();

          $stmt = $db->prepare("DELETE FROM items WHERE itemid = ?");
          $stmt->bind_param("i", $delete_item_id);
          $stmt->execute();
          $stmt->close();
        }

        // Insert new category
        if (isset($_POST['cat_name'])) {
          $cat_name = $_POST['cat_name'];
          $query = "INSERT INTO category VALUES (NULL, ".$cat_name.")";
          $stmt = $db->prepare("INSERT INTO category (name) VALUES (?)");
          $stmt->bind_param("s", $cat_name);
          $stmt->execute();
          $stmt->close();
        }

        if (isset($_POST['cat_id'])) {
          $cat_id = $_POST['cat_id'];
          
          $stmt = $db->prepare("DELETE sizes FROM sizes INNER JOIN items ON sizes.itemid = items.itemid WHERE items.categoryid = ?");
          $stmt->bind_param("i", $cat_id);
          $stmt->execute();
          $stmt->close();
      
          $stmt = $db->prepare("DELETE FROM items WHERE categoryid = ?");
          $stmt->bind_param("i", $cat_id);
          $stmt->execute();
          $stmt->close();
      
          $stmt = $db->prepare("DELETE FROM category WHERE categoryid = ?");
          $stmt->bind_param("i", $cat_id);
          $stmt->execute();
          $stmt->close();
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
                <input type="text" name="cat_name" required placeholder="New Category">
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
              echo '<h2 style="font-size:xx-large;margin-right:180px" id="'.$cat_id.'">'.$cat_name.'</h2>';
              echo '<form action="editable_items.php" method="post" style="text-align:center">
              <input type="hidden" name="category_id" value="'.$cat_id.'">
              <button type="submit" class="addNewItemButton" style="margin-right:350px">Add New Item</button>
              </form><br><br>';

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
                    $picture = is_null($itemrow["image"]) ? "./img/default.jpg" : "./img/".$itemrow["image"];
                    $query = "SELECT * FROM sizes WHERE itemid = ".$item_id;
                    $sizes = $db->query($query);

                    echo '<div class="box" style="background-color:#ccd8cf">  
                          <div id="verticalflex">
                          <img src='.$picture.' alt="Menu Image">
                          <p style="font-size: 20px">
                            <b>'.$item_name.'</b> <br>
                            '.wordwrap($item_description, 30, "<br>").'
                          </p>';

                    if (isset($sizes)) {
                      while ($sizerow = $sizes->fetch_assoc()) {
                        $size_name = htmlspecialchars($sizerow["name"]);
                        $size_price = htmlspecialchars($sizerow["price"]);
                        echo '<p style="font-size: 16px">'.$size_name.' ($'.$size_price.')</p>';
                      }
                  } 
                  echo '<div>
                  <form action="editable_items.php" method="post">
                  <input type="hidden" name="item_id" value="'.$item_id.'">
                  <input type="hidden" name="category_id" value="'.$cat_id.'">
                  <button type="submit" class="editButton">Edit Item</button>
                  </form>
                  <form action="'.$_SERVER['PHP_SELF'].'" method="post">
                  <input type="hidden" name="delete_item_id" value="'.$item_id.'">
                  <button type="submit" class="editButton">Delete Item</button>
                  </form>
                  </div>
                  </div>   <!-- Close vertical flex div -->
                  </div> <!-- Close box div -->';
                  $itemCounter++;
                  if ($itemCounter == $items->num_rows) {
                    $remainder = $itemCounter % 3;
                    if ($remainder != 0) {
                      for ($x = 3 - $remainder; $x > 0; $x--) {
                        echo '<div class="box"></div>';
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
          echo '</div>';
        ?>
        
<!-- Footer for all pages -->
<!-- <footer>
    <section class="semicircle">
      <img src="./img/leafylogo.png"  alt="Leafy Bites Logo" >
      <h2 style="color: #FFFFFF; font-size:30px">Leafy Bites Proudly Present</h2>
    </section>
  
    <br><br><br>
    <div class="flexcontainer" >
      
        <div class="box">  
          <div id="verticalflex" > <h3>Services</h3><br><br>
            <p style="text-align: center; font-size: 15px;"> We offer delivery too ! <br> Singapore Islandwide <br><br>
              Mon-Fri: 10am - 8pm <br>
              Sat-Sun: 11am - 9pm
            </p>
          </div>
        </div>
  
     
        <div class="box">
          <div id="verticalflex" > <h3>Subscribe to Leafy Bites now to get our special offers !</h3>
            <input style="border: none; border-bottom:solid 2px #115448; background-color: #e3f0e7; text-align: center;" type=email placeholder="Email address">
          </div>
        </div>
  
        <div class="box">
          <div id="verticalflex" > <h3> Contact Us </h3>
            <p style="text-align: center; font-size: 15px;"> HP: +65 8188-6905 (Vilan)<br> HP: +65 8683-4492 (Vignesh)<br><br> Email: leafybitescorp@gmail.com<br><br>
              50 Nanyang Walk, 639929 Singapore
            </p>
          </div>
        </div>
    </div>
  
    <br>Copyright &copy; Leafy Bites 2023 <br> All rights reserved.<br><br>
    <form action="adminlogin.php" method="post">
      <input type="hidden" id="hidden" name="hidden" value="20" />
    </form>
  </footer> -->
</body>

</html>