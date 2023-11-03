<?php
  include "session_start.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Leafy Bites</title>
  <meta charset="utf-8">
  <link rel="stylesheet" href="stylesheet.css">
  <script src='loadPage.js'></script>
  <script src="functionality.js"></script>
</head>

<body>
  <div class="wrapper">
    <header>
      <div class="center">
        <img class="logo" src="./img/leafylogo.png"  alt="Leafy Bites Logo" >
      </div>
      <h1>Leafy Bites</h1>
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
   
    </nav>

    </header>
  </div>
  
  <?php
      
  if (!empty($_SESSION['valid_user'])){
    echo '<script> remove() </script>';
  }
  else {
    echo '<script> changelink() </script>';
  }

  ?>

  <!-- Introduction Tab -->
  <div class="flexcontainer">
      
      <div class="box">
        <img src="./img/introphoto.png"  alt="Introduction Photo">
      </div>

      <div class="box" >
        <div id="verticalflex">
          <h2 style="text-align: left;"> Introducing <b>Leafy Bites</b>: Your Ultimate Fast Food Heaven!</h2>
          <p style="font-size: 20px;"><b>Leafy Bites</b> is here to make your fast food experience easier, faster, and more convenient than ever.</p>
          <p style="font-size: 20px;">From mouthwatering <b>burgers</b> and <b>crispy fries</b> to <b>savory roast chicken</b>, delectable pizza, and so much more. 
            Whether you're a cheeseburger enthusiast or a die-hard fan of cheesy, gooey nachos, we've got something to satiate every craving !</p>
        </div>
      </div>

    </div>
  </div>

  <!-- Daily Specials -->

  <h2 style="padding-top: 50px; font-size:xx-large;">Try Our Daily Specials </h2>
  <div class="flexcontainer" style="background-color: #e3f0e7; margin-top:0px">

      <div class="box" >  
        <div id="verticalflex" > <img src="./img/cheeseburger.jpg" width = 200, height="200" alt="McChicken">
          <p style="text-align: center; font-size: 20px"> <b>Beef Royale</b> <br>
            Leafy Bites makes a jam-packed burger so big, <br>you'll need both hands!
          </p>
        </div>
      </div>

  
      <div class="box">
        <div id="verticalflex" > <img src="./img/tuna_salad.jpg" width = 200, height="200" alt="McChicken">
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

</body>
<footer>
  <div id="footer"></div>
</footer>
</html>


