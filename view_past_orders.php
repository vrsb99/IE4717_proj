<?php
  session_start();
  var_dump($_SESSION['valid_user']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Leafy Bites</title>
  <meta charset="utf-8">
  <link rel="stylesheet" href="stylesheet.css">
  <script src="loadPage.js"></script>

<!-- Container for the website -->
  <div class="wrapper">
    <header>
      <div class="center">
        <img class="logo" src="./img/leafylogo.png"  alt="Leafy Bites Logo" >
      </div>
      <h1 style="color:#115448">Leafy Bites</h1>
      <h1 style="color:#115448">Past Orders</h1>
      <div id="navbar"></div>
    </header>
  </div>

</head>

<body>
  <footer>
    <div id="footer"></div>
  </footer>
</body>

</html>


