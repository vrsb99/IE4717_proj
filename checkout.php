<!DOCTYPE html>
<html lang="en">
<head>
  <title>Leafy Bites</title>
  <meta charset="utf-8">
  <link rel="stylesheet" href="stylesheet.css">
  

  <script>
      document.addEventListener("DOMContentLoaded", function() {
        fetch('navbar.html')
        .then(response => response.text())
        .then(data => {
          document.getElementById('navbar').innerHTML = data;
        });
      });
  </script>
  
  <div class="wrapper">
    <header>
      <div class="center">
        <img class="logo" src="./img/leafylogo.png"  alt="Leafy Bites Logo" >
      </div>
      <h1 style="color:#115448">Leafy Bites</h1>
      <h1 style="color:#115448">Checkout</h1>
      <div id="navbar"></div>
    </header>
  </div>

</head>

<body>
<!-- Container for the website -->


  <?php
    session_start();
    if (!isset($_SESSION['cart'])){
      $_SESSION['cart'] = array();
    }
    
    if (isset($_GET['empty'])) {
      unset($_SESSION['cart']);
      header('location: menu.php');
      exit();
    }
    
    // How to check if _SESSION['cart'] is empty?
    if (!empty($_SESSION['cart'])) {
      @ $db = new mysqli('localhost', 'root', '', 'leafybites');

      if (mysqli_connect_errno()) {
          $script = '<script>alert("Error: Could not connect to database. Please try again later.")</script>';
          exit;
      }

      if (isset($_GET['remove'])) {
        $remove = $_GET['remove'];
        $_SESSION['cart'] = array_diff($_SESSION['cart'], array($remove));
        header('location: ' . $_SERVER['PHP_SELF']);
        exit();
      }

      $cartCounts = array_count_values($_SESSION['cart']); // Counts occurrences of each item 
      $uniqueCart = array_keys($cartCounts); // Gets the unique items
      
      $query = "SELECT items.itemname, sizes.sizeid, sizes.size, sizes.sizeprice FROM items, sizes WHERE items.itemid = sizes.itemid AND sizes.sizeid IN (".implode(',', $uniqueCart).") ORDER BY sizes.sizeid";
      $result = $db->query($query);

      echo '
      <div class="flexcolumncontainer" >
      <form action="status.php" method="post">
      <table border="1">
      <thead>
      <tr>
        <th>Item</th>
        <th>Size</th>
        <th>Unit Price</th>
        <th>Quantity</th>
        <th>Price</th>
      </tr>
      </thead>
      <tbody>';
      
      $total = 0;
      while($row = $result->fetch_assoc()) {
          $sizeid = $row['sizeid'];
          $quantity = $cartCounts[$sizeid];
          $unit_price = $row['sizeprice'];
          $price = $unit_price * $quantity;
          echo "<tr>";
          echo "<td>" . $row['itemname'] . "<br><a href='".$_SERVER["PHP_SELF"]."?remove=".$sizeid."'>Remove</a></td>";
          echo "<td>". $row['size'] . "</td>";
          echo "<td name='unit_price'>$" . $unit_price . "</td>";
          echo "<td><input type='number' min='0' name='quantity_".$sizeid."' value=".$quantity." onchange='priceForQuantity(this)'></td>";
          echo "<td name='price'>$" . number_format($price, 2) . "</td>";
          echo "</tr>";
          $total += $price;
      }      

      echo '</tbody>
        <tfoot>
        <tr>
          <th align="right" colspan="3">Total:</th><br>
          <th align="right" name="total_price" >$'.number_format($total, 2).'
          </th>
        </tr>
        </tfoot>
      </table>
      <p><a href="menu.php">Continue Shopping</a> or
      <a href="'.$_SERVER['PHP_SELF'].'?empty=1">Empty Cart</a></p>

      <label class="labels" for="name">*Name:</label>
      <input class="input-field" type="text" id="name" name="name" required placeholder="Enter your name here"><br><br>

      <label for="email">*E-mail:</label>
      <input type="email" id="email" name="email"  required placeholder="Enter your Email-ID here"><br><br>
      
      <input type="submit" name="submit" value="Place Order" style="font-size: large;">
      </form>
      <script type="text/javascript" src="checkout.js"></script>
      </div>';
    } else {
      header('location: menu.php');
      exit();
    }
    ?>
  <footer>
    <section class="semicircle">
      <img src="./img/leafylogo.png"  alt="Leafy Bites Logo" >
      <h2 style="color: #FFFFFF; font-size:30px">Leafy Bites Proudly Present</h2>
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
            <input type=email placeholder="Email address">
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


