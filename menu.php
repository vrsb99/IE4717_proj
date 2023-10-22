<?php
@ $db = new mysqli('localhost', 'root', '', 'leafybites');

if (mysqli_connect_errno()) {
    $script = '<script>alert("Error: Could not connect to database. Please try again later.")</script>';
    exit;
}

$query = "SELECT * FROM category";
$categories = $db->query($query);
$query = "SELECT * FROM items";
$items = $db->query($query);
$query = "SELECT * FROM sizes";
$sizes = $db->query($query);
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
      
    <h2 style="padding-top: 50px; font-size:xx-large;">Try Our Daily Specials </h2>
    <div class="flexcontainer" style="background-color: #e3f0e7; margin-top:0px">
      
      <div class="box" >  
        <div id="verticalflex" > <img src="./img/trial.jpg" width = 200, height="200" alt="McChicken">
          <p style="text-align: center; font-size: 20px"> <b>Beef Royale</b> <br>
            Leafy Bites makes a jam-packed burger so big, <br>you'll need both hands!
          </p>
        </div>
      </div>


      <div class="box">
        <div id="verticalflex" > <img src="./img/pizzarice.jpg" width = 200, height="200" alt="McChicken">
          <p style="text-align: center;font-size: 20px"> <b>Pizza Rice</b> <br>
            All the flavours of a vegetarian supreme, <br>baked into crispy, chewy rice.
          </p>
        </div>
      </div>

      <div class="box">
        <div id="verticalflex" > <img src="./img/roastchicken.jpg" width = 200, height="200" alt="McChicken">
          <p style="text-align: center;font-size: 20px"> <b>Roast Tikka Chicken</b> <br>
            A new spin on the classic roast chook. <br>Highly recommended by our regulars!
          </p>
        </div>
      </div>
      <br><br><br>

    </div>
        
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