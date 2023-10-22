<?php
@ $db = new mysqli('localhost', 'root', '', 'leafybites');

if (mysqli_connect_errno()) {
    $script = '<script>alert("Error: Could not connect to database. Please try again later.")</script>';
    exit;
}

$query = "SELECT * FROM category";
$categories = $db->query($query);
$num_categories = $categories->num_rows;
$query = "SELECT * FROM items";
$items = $db->query($query);
$num_items = $items->num_rows;
$query = "SELECT * FROM sizes";
$sizes = $db->query($query);
$num_sizes = $sizes->num_rows;
?>

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
        if (isset($categories)){
          for ($catid = 1; $catid <= $num_categories; $catid++) {
            $catrow = $categories->fetch_assoc();
            $cat_name = $catrow['categoryname'];
            echo '<h2 style="padding-top: 50px; font-size:xx-large;">'.$cat_name.'</h2>';
            echo '<div class="flexcontainer" style="background-color: #e3f0e7; margin-top:0px">';
            if (isset($items)) {
              for ($itemid = 1 ; $itemid <= $num_items; $itemid++) {
                $itemrow = $items->fetch_assoc();
                if ((int) $itemrow["categoryid"] == $catid) {
                  $item_name = $itemrow["itemname"];
                  $item_description = $itemrow["itemdescription"];
                  echo '<div class="box" >  
                          <div id="verticalflex" > <img src="./img/roastchicken.jpg" width = 200, height="200" alt="McChicken">
                            <p style="text-align: center; font-size: 20px"> <b>'.$item_name.'</b> <br>
                              '.$item_description.'
                            </p>
                          </div>
                        </div>';
                }
              }
              $items->data_seek(0);
            }
            echo '</div>';
          }
        }
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