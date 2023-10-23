<!DOCTYPE html>
<html lang="en">
<head>
  <title>Leafy Bites</title>
  <meta charset="utf-8">
  <link rel="stylesheet" href="stylesheet.css">
  
  
  <script>
      document.addEventListener("DOMContentLoaded", function() {
        fetch('components.html')
        .then(response => response.text())
        .then(data => {
          document.getElementById('navbar').innerHTML = data;
        });
      });
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
      <div id="navbar"></div>
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
          echo '<div class="leftcolumn">
                <nav class="sidenav">
                  <ul>';
          while ($catrow = $categories->fetch_assoc()) {
            $cat_id = $catrow['categoryid'];
            $cat_name = $catrow['categoryname'];
            echo '<li><a href="#'.$cat_id.'">'.$cat_name.'</a></li>';
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
                                $size_name = $sizerow["size"];
                                $size_price = $sizerow["sizeprice"];
                                echo '<option value='.$size_id.'>'.$size_name.' ($'.$size_price.')</option>';
                            }
                        }
                  echo '</select>
                      <button class="addButton">ADD</button>
                    </div>
                </div>';
                }
              }
              echo '</div>';
            }
          }
          echo '</div>';
        ?>
        
  <footer>
    <section class="semicircle">
      <img src="./img/leafylogo.png"  alt="Leafy Bites Logo" >
      <h2 style="color: #FFFFFF; font-size:30px">Leafy Bites Proudly Presents</h2>
    </section>
    <br><br><br>
    <div class="flexcontainer" >
      <!-- First Box of Daily Specials -->
        <div class="box">  
          <div id="verticalflex" > <h3 style="text-align: center;">Services</h3><br><br>
            <p style="text-align: center;"> We offer delivery too ! <br> Singapore Islandwide <br><br>
              Mon-Fri: 10am - 8pm <br>
              Sat-Sun: 11am - 9pm
            </p>
          </div>
        </div>

      <!-- Second Box of Daily Specials -->
        <div class="box">
          <div id="verticalflex" > <h3 style="text-align: center;">Subscribe to Leafy Bites now to get our special offers !</h3>
            <input style="border: none; border-bottom:solid 2px #115448; background-color: #e3f0e7; text-align: center;" type=email placeholder="Email address">
          </div>
        </div>

        <div class="box">
          <div id="verticalflex" > <h3 style="text-align: center;">Contact Us </h3>
            <p style="text-align: center;"> HP: +65 8188-6905 (Vilan)<br> HP: +65 8683-4492 (Vignesh)<br><br> Email: leafybitescorp@gmail.com<br><br>
              50 Nanyang Walk, 639929 Singapore
            </p>
          </div>
        </div>
    </div>

    <br>Copyright &copy; Leafy Bites 2023 <br> All rights reserved.<br><br>
    <button class="button" onclick="location.href='login.html';">Admin?</button>

  </footer>
</body>

</html>